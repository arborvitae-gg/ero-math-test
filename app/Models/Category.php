<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'min_grade', 'max_grade'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
