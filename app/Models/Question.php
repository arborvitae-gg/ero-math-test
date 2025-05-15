<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'category_id',
        'question_text',
        'question_image',
    ];

    protected $appends = ['question_image_url'];

    public function getQuestionImageUrlAttribute(): ?string
    {
        return $this->question_image
            ? env('SUPABASE_ENDPOINT')."/object/public/".env('SUPABASE_BUCKET')."/{$this->question_image}"
            : null;
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class)->orderBy('id'); // maintain choice position order
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
