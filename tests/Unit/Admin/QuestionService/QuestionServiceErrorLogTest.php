<?php

namespace Tests\Unit\Admin\QuestionService;

use App\Services\Admin\QuestionService;
use App\Services\Admin\SupabaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class QuestionServiceErrorLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_handleQuestionData_logs_on_failure()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andThrow(new \Exception('Upload failed'));
        $service = new QuestionService($supabase);
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $data = [
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
            'question_text' => 'Q1?',
            'question_image' => UploadedFile::fake()->image('fail.png'),
        ];
        \Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'handleQuestionData failed') && isset($context['data']);
        });
        $reflection = new \ReflectionClass($service);
        $method = $reflection->getMethod('handleQuestionData');
        $method->setAccessible(true);
        $this->expectException(\Exception::class);
        $method->invoke($service, $data);
    }

    public function test_handleChoice_logs_and_throws_on_upload_failure()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andThrow(new \Exception('Upload failed'));
        $service = new QuestionService($supabase);

        $quiz = \App\Models\Quiz::factory()->create();
        $category = \App\Models\Category::factory()->create();
        $question = \App\Models\Question::factory()->create([
            'quiz_id' => $quiz->id,
            'category_id' => $category->id,
        ]);
        $choiceData = [
            'choice_text' => 'A',
            'choice_image' => UploadedFile::fake()->image('fail.png'),
        ];
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'Choice image upload failed') && isset($context['question_id']);
        });

        $this->expectException(\Exception::class);
        $service->handleChoice($question, $choiceData, 0);
    }

    public function test_uploadFile_logs_and_throws_on_failure()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andThrow(new \Exception('Upload failed'));
        $service = new QuestionService($supabase);
        $file = UploadedFile::fake()->image('test.png');
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'File upload to Supabase failed') && isset($context['file']);
        });

        $this->expectException(\Exception::class);
        $service->uploadFile($file, 'questions');
    }

}
