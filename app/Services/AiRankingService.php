<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AiRankingService
{
    protected string $baseUrl;
    protected string $authToken;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('ai_service.base_url');
        $this->authToken = config('ai_service.auth_token');
        $this->timeout = config('ai_service.timeout');
    }

    /**
     * Rank aid requests by urgency using AI service
     *
     * @param array $requests Array of request data
     * @return array Ranked requests with urgency scores
     * @throws Exception
     */
    public function rankRequests(array $requests): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post($this->baseUrl . config('ai_service.endpoints.rank'), [
                    'auth_token' => $this->authToken,
                    'requests' => $requests
                ]);

            if (!$response->successful()) {
                Log::error('AI Service request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'requests_count' => count($requests)
                ]);
                
                throw new Exception('AI service request failed with status: ' . $response->status());
            }

            $data = $response->json();
            
            if (!isset($data['ranked_requests'])) {
                throw new Exception('Invalid response format from AI service');
            }

            return $data['ranked_requests'];

        } catch (Exception $e) {
            Log::error('AI Ranking Service Error', [
                'message' => $e->getMessage(),
                'requests_count' => count($requests)
            ]);
            
            // Return original requests if AI service fails
            return $this->fallbackRanking($requests);
        }
    }

    /**
     * Check if AI service is healthy
     *
     * @return bool
     */
    public function isHealthy(): bool
    {
        try {
            $response = Http::timeout(5)
                ->get($this->baseUrl . config('ai_service.endpoints.health'));
            
            return $response->successful() && 
                   isset($response->json()['status']) && 
                   $response->json()['status'] === 'healthy';
        } catch (Exception $e) {
            Log::warning('AI Service health check failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Fallback ranking method when AI service is unavailable
     * Sorts by importance field or creation date
     *
     * @param array $requests
     * @return array
     */
    protected function fallbackRanking(array $requests): array
    {
        // Add fallback urgency scores based on importance field
        $processedRequests = array_map(function ($request) {
            $importance = $request['importance'] ?? 1;
            $percentDone = $request['percent_done'] ?? 0;
            
            // Simple fallback scoring
            $urgencyScore = $importance * (1 + $percentDone);
            
            return array_merge($request, [
                'urgency_label' => $this->getUrgencyLabel($importance),
                'urgency_score_model' => $importance / 5.0, // Normalize to 0-1
                'urgency_score_aggressive' => $urgencyScore,
                'fallback_ranking' => true
            ]);
        }, $requests);

        // Sort by urgency score descending
        usort($processedRequests, function ($a, $b) {
            return $b['urgency_score_aggressive'] <=> $a['urgency_score_aggressive'];
        });

        return $processedRequests;
    }

    /**
     * Get urgency label based on importance score
     *
     * @param int $importance
     * @return string
     */
    protected function getUrgencyLabel(int $importance): string
    {
        return match (true) {
            $importance >= 4 => 'High urgency',
            $importance >= 3 => 'Medium urgency',
            default => 'Low urgency'
        };
    }

    /**
     * Format request data for AI service
     *
     * @param object $requestCase
     * @return array
     */
    public function formatRequestForAI($requestCase): array
    {
        // Safely get user information
        $requestedBy = 'Unknown';
        if ($requestCase->user) {
            $requestedBy = $requestCase->user->username ?? $requestCase->user->aliasname ?? 'Unknown';
        }

        // Build comprehensive description for AI analysis
        $fullDescription = $this->buildFullDescription($requestCase);

        return [
            'id' => (int) $requestCase->id,
            'description' => $fullDescription,
            'importance' => (int) $requestCase->importance,
            'percent_done' => (float) $this->calculatePercentDone($requestCase),
            'school' => $requestCase->userName ?? 'Unknown School',
            'requested_by' => $requestedBy,
            'mobile_number' => (string) $requestCase->mobile_number,
            'status' => $requestCase->status ?? 'pending',
            'goal_quantity' => (int) ($requestCase->goal_quantity ?? 0),
            'fulfilled_quantity' => (int) ($requestCase->fulfilled_quantity ?? 0),
            'created_at' => $requestCase->created_at ? $requestCase->created_at->toISOString() : null
        ];
    }

    /**
     * Build comprehensive description for AI analysis
     *
     * @param object $requestCase
     * @return string
     */
    protected function buildFullDescription($requestCase): string
    {
        $parts = [];
        
        // Add title if available
        if (!empty($requestCase->title)) {
            $parts[] = "Title: " . $requestCase->title;
        }
        
        // Add main description
        if (!empty($requestCase->description)) {
            $parts[] = "Description: " . $requestCase->description;
        }
        
        // Add context information
        $goalQty = $requestCase->goal_quantity ?? 0;
        $fulfilledQty = $requestCase->fulfilled_quantity ?? 0;
        
        if ($goalQty > 0) {
            $parts[] = "Goal: {$goalQty} units needed, {$fulfilledQty} units fulfilled so far.";
        }
        
        // Add urgency indicators based on importance
        if ($requestCase->importance >= 4) {
            $parts[] = "HIGH PRIORITY REQUEST - Immediate attention required.";
        } elseif ($requestCase->importance >= 3) {
            $parts[] = "Medium priority request - Important but not urgent.";
        }
        
        return implode(' ', $parts);
    }

    /**
     * Calculate percentage completion for a request case
     *
     * @param object $requestCase
     * @return float
     */
    protected function calculatePercentDone($requestCase): float
    {
        $goalQuantity = $requestCase->goal_quantity ?? 0;
        $fulfilledQuantity = $requestCase->fulfilled_quantity ?? 0;
        
        // Handle edge cases
        if ($goalQuantity <= 0) {
            return 0.0;
        }
        
        if ($fulfilledQuantity <= 0) {
            return 0.0;
        }
        
        // Calculate percentage and ensure it's between 0.0 and 1.0
        $percentage = $fulfilledQuantity / $goalQuantity;
        return min(1.0, max(0.0, $percentage));
    }
}