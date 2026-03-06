<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\UserInventory;
use App\Models\Voucher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Menampilkan Koban Ichiba (Toko).
     * Berisi daftar item (Rak Kayu Estetik) dan saldo Koban user.
     */
    public function index()
    {
        $items = Item::all();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('store.index', compact('items', 'user'));
    }

    /**
     * Membeli item dari toko.
     * Mengurangi Koban dan menambahkan ke inventori user.
     */
    public function purchase(Item $item)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika item bertipe kosmetik (skin/theme), pastikan user belum memilikinya
        if (in_array($item->type, ['skin', 'theme'])) {
            $alreadyOwned = UserInventory::where('user_id', $user->id)
                                         ->where('item_id', $item->id)
                                         ->exists();
            if ($alreadyOwned) {
                return back()->with('error', 'Anda sudah memiliki ' . $item->name . '! Tidak perlu membelinya lagi.');
            }
        }

        if ($user->koban < $item->price) {
            return back()->with('error', 'Koban Anda tidak cukup! Kumpulkan lebih banyak dari kuis.');
        }

        // Transaksi pengurangan Koban
        $user->decrement('koban', $item->price);

        // Tambahkan item ke Inventori User
        $inventory = UserInventory::firstOrNew([
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);
        $inventory->quantity++;
        $inventory->save();

        // Catat riwayat transaksi di database
        Transaction::create([
            'user_id' => $user->id,
            'amount' => -$item->price,
            'type' => 'purchase',
            'description' => 'Membeli ' . $item->name
        ]);

        return back()->with('success', $item->name . ' berhasil dibeli! Cek profil Anda.');
    }

    /**
     * Menukarkan kode Voucher (Mystery Gift).
     * Voucher bersifat sekali pakai (is_used = true).
     */
    public function redeem(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $voucher = Voucher::where('code', $request->code)->where('is_used', false)->first();

        if (!$voucher) {
            return back()->with('error', 'Kode voucher tidak valid atau sudah digunakan.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->increment('koban', $voucher->koban_reward);
        $voucher->update(['is_used' => true]);

        // Catat riwayat transaksi klaim voucher untuk audit trail
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $voucher->koban_reward,
            'type' => 'voucher',
            'description' => 'Klaim Kode Voucher: ' . $voucher->code
        ]);

        return back()->with('success', 'Voucher berhasil ditukar! Anda mendapat ' . $voucher->koban_reward . ' Koban.');
    }

    /**
     * Sistem O-mikuji (Gacha Ramalan).
     * Berbiaya 100 Koban untuk mendapatkan pesan keberuntungan acak.
     */
    public function drawOmikuji()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek saldo sebelum penarikan
        if ($user->koban < 100) {
            return back()->with('error', 'Koban tidak cukup untuk O-mikuji (Butuh 100 🪙).');
        }

        $user->decrement('koban', 100);

        // Catat riwayat transaksi untuk audit trail
        Transaction::create([
            'user_id' => $user->id,
            'amount' => -100,
            'type' => 'omikuji',
            'description' => 'Menarik gacha O-mikuji'
        ]);

        // Kumpulan ramalan acak (Poetic)
        $fortunes = [
            ['type' => 'blessing', 'message' => 'Daikichi (大吉) - Keberuntungan Luar Biasa! Semangat belajarmu akan membuahkan hasil manis.'],
            ['type' => 'blessing', 'message' => 'Chukichi (中吉) - Keberuntungan Sedang. Hari yang baik untuk menghafal Kanji baru.'],
            ['type' => 'blessing', 'message' => 'Shokichi (小吉) - Keberuntungan Kecil. Langkah kecil hari ini adalah sukses besar esok.'],
            ['type' => 'future', 'message' => 'Suekichi (末吉) - Keberuntungan di Akhir. Sabarlah, hasil belajarmu akan terlihat nanti.'],
            ['type' => 'future', 'message' => 'Kyo (凶) - Kurang Beruntung. Jangan menyerah! Kegagalan adalah awal dari penguasaan.'],
        ];

        $result = $fortunes[array_rand($fortunes)];

        return back()->with('omikuji_result', $result)->with('success', 'O-mikuji telah ditarik!');
    }
}
