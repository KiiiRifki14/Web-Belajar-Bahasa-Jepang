<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoryAlbum extends Model
{
    /**
     * Catatan prestasi Boss Level.
     */
    protected $fillable = [
        'user_id',
        'level_id',
        'image_path',
        'earned_at'
    ];

    /**
     * Relasi ke User pemilik prestasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Level Boss yang berhasil dikalahkan.
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
