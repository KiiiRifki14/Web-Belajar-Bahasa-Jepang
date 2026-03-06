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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Fetch all regions with their levels to build the map

        // Ambil semua wilayah dan level untuk peta
        $regions = Region::with('levels')->orderBy('order')->get();

        // Ambil progress user
        $progress = UserProgress::where('user_id', $user->id)
            ->pluck('status', 'level_id');

        // Hitung mundur otomatis ke JLPT terdekat (Ujian selalu Minggu pertama Juli/Desember)
        $now = now()->startOfDay();
        $year = $now->year;

        $julyJLPT = Carbon::parse("first sunday of july {$year}");
        $decemberJLPT = Carbon::parse("first sunday of december {$year}");

        if ($now->isBefore($julyJLPT) || $now->isSameDay($julyJLPT)) {
            $nextJLPT = $julyJLPT;
            $jlptMonth = 'Juli';
        } elseif ($now->isBefore($decemberJLPT) || $now->isSameDay($decemberJLPT)) {
            $nextJLPT = $decemberJLPT;
            $jlptMonth = 'Desember';
        } else {
            $nextJLPT = Carbon::parse("first sunday of july " . ($year + 1));
            $jlptMonth = 'Juli';
        }

        $daysToJLPT = $now->diffInDays($nextJLPT, false);

        // Ambil satu catatan rahasia secara acak untuk Neko-Sensei
        $secretNote = SecretNote::inRandomOrder()->first();

        // Cek apakah bisa klaim hadiah harian
        $canClaimDaily = !$user->last_daily_claim || !Carbon::parse($user->last_daily_claim)->isToday();

        return view('dashboard', compact('user', 'regions', 'progress', 'daysToJLPT', 'jlptMonth', 'secretNote', 'canClaimDaily'));
    }

    /**
     * Klaim hadiah Koban harian.
     */
    public function claimDaily()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->last_daily_claim || !Carbon::parse($user->last_daily_claim)->isToday()) {
            $user->increment('koban', 50);
            $user->update(['last_daily_claim' => now()]);

            // Catat riwayat transaksi hadiah harian untuk audit trail
            Transaction::create([
                'user_id' => $user->id,
                'amount' => 50,
                'type' => 'daily_reward',
                'description' => 'Klaim Hadiah Harian'
            ]);

            return back()->with('success', 'Selamat! Anda mendapat 50 Koban hari ini! 🪙');
        }

        return back()->with('error', 'Anda sudah mengklaim hadiah hari ini.');
    }

    public function updateMood(Request $request)
    {
        $request->validate([
            'mood' => 'required|string|in:happy,neutral,sad,angry'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->mood = $request->mood;
        $user->save();

        return back()->with('success', 'Mood updated! Quiz difficulty adjusted.');
    }
}
