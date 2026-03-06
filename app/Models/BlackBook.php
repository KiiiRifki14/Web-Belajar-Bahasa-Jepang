<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackBook extends Model
{
    protected $fillable = ['user_id', 'question_id', 'wrong_count', 'correct_streak', 'is_mastered'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
