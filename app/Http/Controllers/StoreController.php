<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\UserInventory;
use App\Models\Transaction;
use App\Models\Voucher;
use App\Models\SecretNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = Item::all();
        $inventory = $user->inventories()->with('item')->get();

        return view('store.index', compact('items', 'user', 'inventory'));
    }

    public function purchase(Item $item)
    {
        $user = Auth::user();

        if ($user->koban < $item->price) {
            return back()->with('error', 'Not enough Koban! Win more quizzes to earn coins.');
        }

        DB::transaction(function () use ($user, $item) {
            // Deduct Koban
            $user->koban -= $item->price;
            $user->save();

            // Record Transaction
            Transaction::create([
                'user_id' => $user->id,
                'amount' => -$item->price,
                'type' => 'purchase',
                'description' => "Purchased item: {$item->name}"
            ]);

            // Add to Inventory
            $inventory = UserInventory::firstOrNew([
                'user_id' => $user->id,
                'item_id' => $item->id
            ]);
            $inventory->quantity += 1;
            $inventory->save();
        });

        return back()->with('success', "Success! You bought {$item->name}. View it in your inventory.");
    }

    public function omikuji()
    {
        $user = Auth::user();
        $cost = 100;

        if ($user->koban < $cost) {
            return back()->with('error', 'O-mikuji requires 100 Koban for a blessing.');
        }

        return DB::transaction(function () use ($user, $cost) {
            $user->koban -= $cost;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => -$cost,
                'type' => 'purchase',
                'description' => 'Drew an O-mikuji fortune'
            ]);

            // Random Reward
            $roll = rand(1, 100);
            $reward = null;
            $message = '';

            if ($roll <= 10) {
                // Jackpot: High Koban Reward
                $amount = rand(200, 500);
                $user->koban += $amount;
                $user->save();
                $message = "Dai-kichi (Great Blessing)! You found a hidden stash of {$amount} Koban!";
            } elseif ($roll <= 30) {
                // Item Reward: Random Powerup
                $item = Item::where('type', 'powerup')->inRandomOrder()->first();
                if ($item) {
                    $inventory = UserInventory::firstOrNew(['user_id' => $user->id, 'item_id' => $item->id]);
                    $inventory->quantity += 1;
                    $inventory->save();
                    $message = "Kichi (Good Blessing)! Neko-Sensei gifted you a {$item->name}!";
                }
            } else {
                // Just a Secret Note (Fortune)
                $note = SecretNote::inRandomOrder()->first();
                $message = $note ? $note->content : "Continue your studies with diligence.";
            }

            return back()->with('omikuji_result', [
                'message' => $message,
                'type' => $roll <= 30 ? 'blessing' : 'fortune'
            ]);
        });
    }

    public function redeemVoucher(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        $voucher = Voucher::where('code', $validated['code'])
            ->where('is_redeemed', false)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$voucher) {
            return back()->with('error', 'Invalid or expired voucher code.');
        }

        DB::transaction(function () use ($voucher) {
            $user = Auth::user();

            if ($voucher->reward_type === 'koban') {
                $user->koban += $voucher->reward_amount;
                $user->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $voucher->reward_amount,
                    'type' => 'reward',
                    'description' => "Redeemed voucher: {$voucher->code}"
                ]);
            } elseif ($voucher->reward_type === 'item') {
                $inventory = UserInventory::firstOrNew([
                    'user_id' => $user->id,
                    'item_id' => $voucher->item_id
                ]);
                $inventory->quantity += $voucher->quantity;
                $inventory->save();
            }

            $voucher->is_redeemed = true;
            $voucher->redeemed_at = now();
            $voucher->user_id = $user->id; // Assuming we add user_id to vouchers to track who redeemed
            $voucher->save();
        });

        return back()->with('success', 'Voucher redeemed successfully!');
    }
}
