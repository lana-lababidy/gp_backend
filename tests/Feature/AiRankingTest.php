<?php

namespace Tests\Feature;

use App\Models\RequestCase;
use App\Models\User;
use App\Services\AiRankingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiRankingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock the AI service responses
        Http::fake([
            'localhost:5000/rank' => Http::response([
                'ranked_requests' => [
                    [
                        'id' => 1,
                        'description' => 'Test request',
                        'urgency_label' => 'High urgency',
                        'urgency_score_model' => 0.9,
                        'urgency_score_aggressive' => 1.1,
                        'importance' => 5,
                        'percent_done' => 0.1
                    ]
                ]
            ], 200),
            
            'localhost:5000/health' => Http::response([
                'status' => 'healthy'
            ], 200)
        ]);
    }

    public function test_ai_ranking_service_formats_request_correctly()
    {
        $user = User::factory()->create();
        $requestCase = RequestCase::factory()->create([
            'user_id' => $user->id,
            'description' => 'Need urgent help with school repairs',
            'importance' => 4,
            'goal_quantity' => 1000,
            'fulfilled_quantity' => 100
        ]);

        $aiService = new AiRankingService();
        $formatted = $aiService->formatRequestForAI($requestCase);

        $this->assertArrayHasKey('id', $formatted);
        $this->assertArrayHasKey('description', $formatted);
        $this->assertArrayHasKey('importance', $formatted);
        $this->assertArrayHasKey('percent_done', $formatted);
        $this->assertEquals(0.1, $formatted['percent_done']); // 100/1000
    }

    public function test_pending_requests_returns_ai_ranked_results()
    {
        $user = User::factory()->create();
        $requestCase = RequestCase::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'description' => 'Urgent school repair needed',
            'importance' => 5
        ]);

        $response = $this->postJson('/api/request-cases/pending');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'data' => [
                        '*' => [
                            'id',
                            'description',
                            'ai_ranking' => [
                                'urgency_label',
                                'urgency_score_model',
                                'urgency_score_aggressive',
                                'is_fallback'
                            ]
                        ]
                    ],
                    'ai_service_healthy'
                ]);
    }

    public function test_fallback_ranking_when_ai_service_unavailable()
    {
        Http::fake([
            'localhost:5000/*' => Http::response([], 500)
        ]);

        $user = User::factory()->create();
        $requestCase = RequestCase::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'importance' => 3
        ]);

        $response = $this->postJson('/api/request-cases/pending');

        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'ai_service_healthy' => false
                ]);
    }
}