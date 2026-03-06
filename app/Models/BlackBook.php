<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackBook extends Model
{
    /**
     * Field yang dapat diisi.
     * is_mastered akan bernilai true jika user menjawab benar 3x berturut-turut.
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'wrong_count',
        'correct_streak',
        'is_mastered'
    ];

    /**
     * Relasi ke User pemilik catatan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Soal yang dijawab salah tersebut.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
