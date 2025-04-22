<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    protected $fillable = [
        'question_id',
        'choice_content',
        'choice_type',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
