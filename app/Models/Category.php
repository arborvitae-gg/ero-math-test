<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a quiz category (e.g., grade level group).
 *
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_grade',
        'max_grade'
        ];

        /**
     * Get all questions for this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all quizzes for this category (via questions).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function quizzes()
    {
        return $this->hasManyThrough(Quiz::class, Question::class);
    }

    /**
     * Find the category for a given grade level.
     *
     * @param int $gradeLevel
     * @return static|null
     */
    public static function findCategoryForGrade($gradeLevel)
    {
        return self::where('min_grade', '<=', $gradeLevel)
                   ->where('max_grade', '>=', $gradeLevel)
                   ->first();
    }
}
