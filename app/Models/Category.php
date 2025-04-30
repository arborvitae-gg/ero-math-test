<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'min_grade',
        'max_grade'
        ];

        public function questions()
        {
            return $this->hasMany(Question::class);
        }

        public function quizzes()
        {
            return $this->hasManyThrough(Quiz::class, Question::class);
        }

        public static function findCategoryForGrade($gradeLevel)
        {
            return self::where('min_grade', '<=', $gradeLevel)
                       ->where('max_grade', '>=', $gradeLevel)
                       ->first();
        }
}
