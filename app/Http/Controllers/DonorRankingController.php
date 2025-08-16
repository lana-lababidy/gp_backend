<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DonorRankingController extends Controller
{

    public function index()
    {
        $ranking = Rank::with('user')
            ->orderByDesc('total_points')
            ->get()
            ->map(function ($rank, $index) {
                $user = $rank->user;
                return [
                    'rank'   => $index + 1,
                    'name'   => $user ? ($user->aliasname ?? $user->username) : 'Unknown',
                    'points' => $rank->total_points,
                    'cases'  => $user ? $user->donations()->count() : 0,
                ];
            });


        return response()->json([
            'ranking' => $ranking
        ]);
    }
}
