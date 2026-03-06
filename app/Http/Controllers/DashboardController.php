<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\SecretNote;
use App\Models\UserProgress;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all regions with their levels to build the map
        $regions = Region::with(['levels' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get();

        // Fetch user progress
        $progress = UserProgress::where('user_id', $user->id)
            ->pluck('status', 'level_id')
            ->toArray();

        // Get a random active secret note
        $secretNote = SecretNote::where('is_active', true)->inRandomOrder()->first();

        // Countdown to JLPT December
        $jlptDate = Carbon::create(Carbon::now()->year, 12, 1, 0, 0, 0);
        if ($jlptDate->isPast()) {
            $jlptDate->addYear();
        }
        $daysToJLPT = (int) now()->diffInDays($jlptDate);

        // Daily Reward Check
        $canClaimDaily = !$user->last_daily_reward_at || !now()->isSameDay($user->last_daily_reward_at);

        return view('dashboard', compact('user', 'regions', 'progress', 'secretNote', 'daysToJLPT', 'canClaimDaily'));
    }

    public function claimDaily()
    {
        $user = Auth::user();

        if ($user->last_daily_reward_at && now()->isSameDay($user->last_daily_reward_at)) {
            return back()->with('error', 'You already claimed your daily gift!');
        }

        $reward = 50; // Simple reward
        $user->koban += $reward;
        $user->last_daily_reward_at = now();
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $reward,
            'type' => 'reward',
            'description' => 'Daily Login Reward'
        ]);

        return back()->with('success', "Okaeri! You received {$reward} Koban as a daily gift.");
    }

    public function updateMood(Request $request)
    {
        $request->validate([
            'mood' => 'required|string|in:happy,neutral,sad,angry'
        ]);

        $user = Auth::user();
        $user->mood = $request->mood;
        $user->save();

        return back()->with('success', 'Mood updated! Quiz difficulty adjusted.');
    }
}
