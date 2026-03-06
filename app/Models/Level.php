<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['region_id', 'name', 'order', 'is_boss_level', 'required_streak'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
