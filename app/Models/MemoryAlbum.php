<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoryAlbum extends Model
{
    protected $fillable = ['user_id', 'level_id', 'image_path', 'earned_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
