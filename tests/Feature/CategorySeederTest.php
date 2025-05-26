<?php
// Test that categories are seeded correctly
use App\Models\Category;

test('categories are seeded on migration', function () {
    $categories = Category::all();
    expect($categories)->not()->toBeEmpty();
    expect($categories->count())->toBeGreaterThanOrEqual(5);
    expect($categories->pluck('name'))->toContain('Level 1');
});
