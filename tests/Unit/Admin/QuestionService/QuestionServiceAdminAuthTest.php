<?php

namespace Tests\Unit\Admin\QuestionService;

use App\Services\Admin\QuestionService;
use App\Services\Admin\SupabaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class QuestionServiceAdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_restricted_to_admin()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
            'choices' => [
                ['choice_text' => 'A'],
                ['choice_text' => 'B'],
            ],
        ];
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only admins can perform this action.');
        $service->store($data);
    }

    public function test_update_restricted_to_admin()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $question = \App\Models\Question::factory()->create([
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
        ]);
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
            'choices' => [
                ['choice_text' => 'A'],
                ['choice_text' => 'B'],
            ],
        ];
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only admins can perform this action.');
        $service->update($question, $data);
    }

    public function test_delete_restricted_to_admin()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $question = \App\Models\Question::factory()->create([
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
        ]);
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only admins can perform this action.');
        $service->delete($question);
    }

    public function test_handleQuestionData_restricted_to_admin()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Sample?',
        ];
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('handleQuestionData');
        $method->setAccessible(true);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only admins can perform this action.');
        $method->invoke($service, $data);
    }

    public function test_handleChoice_restricted_to_admin()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $service = new QuestionService($supabase);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $question = \App\Models\Question::factory()->create([
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
        ]);
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only admins can perform this action.');
        $service->handleChoice($question, ['choice_text' => 'A'], 0);
    }

    public function test_uploadFile_restricted_to_admin()
    {
        $supabase = \Mockery::mock(SupabaseService::class);
        $service = new QuestionService($supabase);
        $file = \Illuminate\Http\UploadedFile::fake()->image('test.png');
        $user = \App\Models\User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Only admins can perform this action.');
        $service->uploadFile($file, 'questions');
    }
}
