<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuizUser extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'category_id',
        'status',
        'current_question',
        'started_at',
        'completed_at',
        'total_score',
        'can_view_score',
        'question_order',
        'uuid'
    ];

    protected $casts = [
        'question_order' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'can_view_score' => 'boolean'
    ];

    protected static function booted()
    {
        static::creating(function ($quizUser) {
            $quizUser->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

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
