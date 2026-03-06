<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Field untuk soal kuis.
     * options disimpan dalam format JSON.
     */
    protected $fillable = [
        'level_id',
        'type',
        'question_text',
        'visual_hint_path',
        'options',
        'correct_answer',
        'explanation'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    /**
     * Relasi ke Level/Materi kuis.
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function blackBooks()
    {
        return $this->hasMany(BlackBook::class);
    }
}
