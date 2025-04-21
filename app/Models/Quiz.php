<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

}
