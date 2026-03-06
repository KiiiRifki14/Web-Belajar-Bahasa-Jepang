<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'reward_type',
        'reward_amount',
        'item_id',
        'quantity',
        'is_redeemed',
        'expires_at'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
