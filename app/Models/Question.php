<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'level_id',
        'type',
        'difficulty',
        'question_text',
        'visual_hint_path',
        'options',
        'correct_answer',
        'explanation'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
