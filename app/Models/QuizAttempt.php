<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_user_id',
        'question_id',
        'question_choice_id',
        'is_correct',
        'answered_at',
    ];

    protected $dates = ['answered_at'];

    public function quizUser()
    {
        return $this->belongsTo(QuizUser::class);
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
