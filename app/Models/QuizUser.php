<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    protected $fillable = [
        'quiz_id', 'user_id', 'category_id',
        'status', 'total_score', 'started_at',
        'completed_at', 'can_view_score',
        'current_question', // ???
        'question_order' // ???
    ];

    protected $dates = ['started_at', 'completed_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
