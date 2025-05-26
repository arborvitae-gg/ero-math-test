<?php
// Feature test for admin question management
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Category;

test('admin can add a question to a quiz', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $quiz = Quiz::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($admin);
    $response = $this->post(route('admin.quizzes.questions.store', $quiz), [
        'question_text' => 'What is 2+2?',
        'category_id' => $category->id,
        'choices' => [
            ['choice_text' => '4'],
            ['choice_text' => '3'],
            ['choice_text' => '5'],
            ['choice_text' => '2'],
        ],
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('questions', ['question_text' => 'What is 2+2?']);
});

test('admin can update a question', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $quiz = Quiz::factory()->create();
    $category = Category::factory()->create();
    $question = Question::factory()->create(['quiz_id' => $quiz->id, 'category_id' => $category->id]);
    $this->actingAs($admin);
    $response = $this->patch(route('admin.quizzes.questions.update', [$quiz, $question]), [
        'question_text' => 'Updated?',
        'category_id' => $category->id,
        'choices' => [
            ['choice_text' => 'Updated 1'],
            ['choice_text' => 'Updated 2'],
            ['choice_text' => 'Updated 3'],
            ['choice_text' => 'Updated 4'],
        ],
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('questions', ['question_text' => 'Updated?']);
});

test('admin can delete a question', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $quiz = Quiz::factory()->create();
    $category = Category::factory()->create();
    $question = Question::factory()->create(['quiz_id' => $quiz->id, 'category_id' => $category->id]);
    $this->actingAs($admin);
    $response = $this->delete(route('admin.quizzes.questions.destroy', [$quiz, $question]));
    $response->assertRedirect();
    $this->assertDatabaseMissing('questions', ['id' => $question->id]);
});

test('non-admin cannot access admin question routes', function () {
    $user = User::factory()->create(['role' => 'user']);
    $quiz = Quiz::factory()->create();
    $this->actingAs($user);
    $response = $this->get(route('admin.quizzes.questions.index', $quiz));
    $response->assertForbidden();
});
