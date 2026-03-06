<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with('item')->latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $items = Item::all();
        return view('admin.vouchers.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'reward_type' => 'required|in:koban,item',
            'reward_amount' => 'required_if:reward_type,koban|integer|min:0',
            'item_id' => 'required_if:reward_type,item|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        Voucher::create($validated);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher deleted.');
    }
}
