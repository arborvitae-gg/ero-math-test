<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'quiz_user_id',
        'question_id',
        'question_choice_id',
        'is_correct',
        'answered_at',
        'choice_order'
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'choice_order' => 'array'
    ];

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
