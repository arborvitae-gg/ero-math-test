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
        return $this->choice_image
            ? env('SUPABASE_ENDPOINT')."/object/public/".env('SUPABASE_BUCKET')."/{$this->choice_image}"
            : null;
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
