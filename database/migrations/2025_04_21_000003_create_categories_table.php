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
        // Insert default categories after table creation
        \DB::table('categories')->insert([
            ['name' => 'Level 1', 'min_grade' => 3, 'max_grade' => 4],
            ['name' => 'Level 2', 'min_grade' => 5, 'max_grade' => 6],
            ['name' => 'Level 3', 'min_grade' => 7, 'max_grade' => 8],
            ['name' => 'Level 4', 'min_grade' => 9, 'max_grade' => 10],
            ['name' => 'Level 5', 'min_grade' => 11, 'max_grade' => 12],
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
