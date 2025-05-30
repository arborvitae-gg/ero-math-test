<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Beginner", "Intermediate"
            $table->unsignedTinyInteger('min_grade');
            $table->unsignedTinyInteger('max_grade');
            $table->timestamps();
        });
        // Insert default categories after table creation.
        // Creation and editing of categories would be better instead of being limited to fixed categories.
        \DB::table('categories')->insert([
            ['name' => 'Category 1', 'min_grade' => 3, 'max_grade' => 4],
            ['name' => 'Category 2', 'min_grade' => 5, 'max_grade' => 6],
            ['name' => 'Category 3', 'min_grade' => 7, 'max_grade' => 8],
            ['name' => 'Category 4', 'min_grade' => 9, 'max_grade' => 10],
            ['name' => 'Category 5', 'min_grade' => 11, 'max_grade' => 12],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
