<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'is_posted',
        'timer'
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug'; // or 'title' if you slugify it later
    // }

    public function users()
    {
        return $this->hasMany(QuizUser::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
