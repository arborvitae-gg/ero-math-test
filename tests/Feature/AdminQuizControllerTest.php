<?php
// Feature test for admin quiz management
use App\Models\User;
use App\Models\Quiz;

test('admin can create a quiz', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post(route('admin.quizzes.store'), [
        'title' => 'Sample Quiz',
        'slug' => 'sample-quiz',
        'is_posted' => false,
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('quizzes', ['title' => 'Sample Quiz']);
});

test('admin can update a quiz', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $quiz = Quiz::factory()->create();
    $this->actingAs($admin);
    $response = $this->patch(route('admin.quizzes.update', $quiz), [
        'title' => 'Updated Quiz',
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('quizzes', ['title' => 'Updated Quiz']);
});

test('admin can delete a quiz', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $quiz = Quiz::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete(route('admin.quizzes.destroy', $quiz));
    $response->assertRedirect();
    $this->assertDatabaseMissing('quizzes', ['id' => $quiz->id]);
});

test('non-admin cannot access admin quiz routes', function () {
    $user = User::factory()->create(['role' => 'user']);
    $quiz = Quiz::factory()->create();
    $this->actingAs($user);
    $response = $this->get(route('admin.quizzes.index'));
    $response->assertForbidden();
});
