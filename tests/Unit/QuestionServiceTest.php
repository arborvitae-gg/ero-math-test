<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Services\Admin\QuestionService;
use App\Services\Admin\SupabaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class QuestionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploadFile_logs_and_throws_on_failure()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andThrow(new \Exception('Upload failed'));
        $service = new QuestionService($supabase);
        $file = UploadedFile::fake()->image('test.png');

        Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'File upload to Supabase failed') && isset($context['file']);
        });

        $this->expectException(\Exception::class);
        $service->uploadFile($file, 'questions');
    }

    public function test_handleChoice_logs_and_throws_on_upload_failure()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andThrow(new \Exception('Upload failed'));
        $service = new QuestionService($supabase);

        $question = Question::factory()->create();
        $choiceData = [
            'choice_text' => 'A',
            'choice_image' => UploadedFile::fake()->image('fail.png'),
        ];

        Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'Choice image upload failed') && isset($context['question_id']);
        });

        $this->expectException(\Exception::class);
        $service->handleChoice($question, $choiceData, 0);
    }

    public function test_uploadFile_succeeds_for_admin_and_user()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->twice();
        $service = new QuestionService($supabase);
        $file = UploadedFile::fake()->image('test.png');

        // Admin
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $resultAdmin = $service->uploadFile($file, 'questions');
        $this->assertStringContainsString('questions/', $resultAdmin);

        // User
        $user = \App\Models\User::factory()->create(['role' => 'user', 'grade_level' => 5, 'school' => 'Sample', 'coach_name' => 'Ms. Smith']);
        $resultUser = $service->uploadFile($file, 'questions');
        $this->assertStringContainsString('questions/', $resultUser);
    }

    public function test_handleChoice_creates_choice_for_admin_and_user()
    {
        $supabase = Mockery::mock(SupabaseService::class);
        $supabase->shouldReceive('uploadImage')->andReturnNull();
        $service = new QuestionService($supabase);

        // Admin
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $questionAdmin = \App\Models\Question::factory()->create(['quiz_id' => 1, 'category_id' => 1]);
        $choiceData = ['choice_text' => 'A', 'choice_image' => UploadedFile::fake()->image('a.png')];
        $service->handleChoice($questionAdmin, $choiceData, 0);
        $this->assertDatabaseHas('question_choices', ['question_id' => $questionAdmin->id, 'choice_text' => 'A']);

        // User
        $user = \App\Models\User::factory()->create(['role' => 'user', 'grade_level' => 5, 'school' => 'Sample', 'coach_name' => 'Ms. Smith']);
        $questionUser = \App\Models\Question::factory()->create(['quiz_id' => 1, 'category_id' => 1]);
        $service->handleChoice($questionUser, $choiceData, 0);
        $this->assertDatabaseHas('question_choices', ['question_id' => $questionUser->id, 'choice_text' => 'A']);
    }
}
