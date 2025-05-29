<?php

namespace Tests\Unit\Admin\QuestionService;

use App\Models\Question;
use App\Services\Admin\QuestionService;
use App\Services\Admin\SupabaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class QuestionServiceFunctionTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_question()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andReturnTrue();
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
            'choices' => [
                ['choice_text' => 'A'],
                ['choice_text' => 'B'],
            ],
        ];
        $question = $service->store($data);
        $this->assertDatabaseHas('questions', ['id' => $question->id, 'question_text' => 'Q1?']);
    }

    public function test_update_question()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andReturnTrue();
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
            'choices' => [
                ['choice_text' => 'A'],
                ['choice_text' => 'B'],
            ],
        ];
        $question = $service->store($data);
        $updateData = $data;
        $updateData['question_text'] = 'Q1 updated?';
        $service->update($question, $updateData);
        $this->assertDatabaseHas('questions', ['id' => $question->id, 'question_text' => 'Q1 updated?']);
    }

    public function test_delete_question()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andReturnTrue();
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
            'choices' => [
                ['choice_text' => 'A'],
                ['choice_text' => 'B'],
            ],
        ];
        $question = $service->store($data);
        $service->delete($question);
        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
    }

    public function test_handleQuestionData_data()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andReturnTrue();
        $service = new QuestionService($supabase);
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
        ];
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('handleQuestionData');
        $method->setAccessible(true);
        $result = $method->invoke($service, $data);
        $this->assertEquals($data['quiz_id'], $result['quiz_id']);
        $this->assertEquals($data['category_id'], $result['category_id']);
        $this->assertEquals($data['question_text'], $result['question_text']);
    }

    public function test_handleChoice_data()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andReturnTrue();
        $service = new QuestionService($supabase);
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $question = \App\Models\Question::factory()->create([
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
        ]);
        $choiceData = [
            'choice_text' => 'A',
            'choice_image' => UploadedFile::fake()->image('a.png'),
        ];
        $service->handleChoice($question, $choiceData, 0);
        $this->assertDatabaseHas('question_choices', [
            'question_id' => $question->id,
            'choice_text' => 'A',
        ]);
    }

    public function test_uploadFile_data()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->once();
        $service = new QuestionService($supabase);
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $file = UploadedFile::fake()->image('test.png');
        $result = $service->uploadFile($file, 'questions');
        $this->assertStringContainsString('questions/', $result);
    }
}
