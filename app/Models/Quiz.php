<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'started_at',
        'completed_at',
        'total_score',
    ];

    protected $dates = ['started_at', 'completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

}
