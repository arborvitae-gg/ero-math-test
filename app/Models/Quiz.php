<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'is_posted',
        'timer'
    ];

    protected static function booted()
    {
        static::creating(function ($quiz) {
            $quiz->slug = Str::slug($quiz->title);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizUsers()
    {
        return $this->hasMany(QuizUser::class);
    }
}
