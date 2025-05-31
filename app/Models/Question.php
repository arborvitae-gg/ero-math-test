<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a quiz question.
 *
 * @package App\Models
 */
class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'category_id',
        'question_text',
        'question_image',
    ];

    protected $appends = ['question_image_url'];

    /**
     * Get the full URL for the question image (if any).
     *
     * @return string|null
     */
    public function getQuestionImageUrlAttribute(): ?string
    {
        if (empty($this->question_image)) {
            return null;
        }

        $endpoint = rtrim(env('SUPABASE_ENDPOINT'), '/');
        $bucket = env('SUPABASE_BUCKET');
        $path = ltrim($this->question_image, '/');

        return "{$endpoint}/object/public/{$bucket}/{$path}";
    }

    /**
     * Get the quiz this question belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the category this question belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all choices for this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function choices()
    {
        return $this->hasMany(QuestionChoice::class)->orderBy('id'); // maintain choice position order
    }

    /**
     * Get all attempts for this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
