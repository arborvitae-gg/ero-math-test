<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    protected $fillable = [
        'question_id',
        'choice_text',
        'choice_image',
        'is_correct',
    ];

    protected $appends = ['choice_image_url'];

    public function getChoiceImageUrlAttribute(): ?string
    {
        return $this->choice_image
            ? env('SUPABASE_ENDPOINT')."/object/public/".env('SUPABASE_BUCKET')."/{$this->choice_image}"
            : null;
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
