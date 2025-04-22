<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_id',
        'question_choice_id',
        'is_correct',
        'answered_at',
    ];

    protected $dates = ['answered_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function choice()
    {
        return $this->belongsTo(QuestionChoice::class, 'question_choice_id');
    }
}
