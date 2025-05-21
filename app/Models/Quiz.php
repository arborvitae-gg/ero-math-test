<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Model representing a quiz.
 *
 * @package App\Models
 */
class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'is_posted',
        'timer'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($quiz) {
            $quiz->slug = Str::slug($quiz->title);
        });
        static::updating(function ($quiz) {
            if ($quiz->isDirty('title')) {
                $quiz->slug = Str::slug($quiz->title);
            }
        });
    }

    /**
     * Get the route key name for Laravel route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all questions for this quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all quiz user attempts for this quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizUsers()
    {
        return $this->hasMany(QuizUser::class);
    }
}
