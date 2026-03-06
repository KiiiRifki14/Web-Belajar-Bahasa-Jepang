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
        'expires_at',
        'user_id',
        'redeemed_at',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
