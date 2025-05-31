<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a possible answer choice for a question.
 *
 * @package App\Models
 */
class QuestionChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'choice_text',
        'choice_image',
        'is_correct',
    ];

    protected $appends = ['choice_image_url'];

    /**
     * Get the full URL for the choice image (if any).
     *
     * @return string|null
     */
    public function getChoiceImageUrlAttribute(): ?string
    {
        if (empty($this->choice_image)) {
            return null;
        }

        $endpoint = rtrim(env('SUPABASE_ENDPOINT'), '/');
        $bucket = env('SUPABASE_BUCKET');
        $path = ltrim($this->choice_image, '/');

        return "{$endpoint}/object/public/{$bucket}/{$path}";
    }

    /**
     * Get the question this choice belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
