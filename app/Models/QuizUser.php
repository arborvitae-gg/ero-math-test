<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Model representing a user's quiz session/attempt.
 *
 * @package App\Models
 */
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
        'question_order',
        'uuid'
    ];

    protected $casts = [
        'question_order' => 'array',
        'choice_orders' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($quizUser) {
            $quizUser->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the route key name for Laravel route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the quiz associated with this attempt.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the user who took the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for this quiz attempt.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all attempts for this quiz session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
