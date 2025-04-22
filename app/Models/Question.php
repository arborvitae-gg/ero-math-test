<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'category_id',
        'question_type',
        'question_content',
    ];

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
