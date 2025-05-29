<?php

namespace Tests\Unit\Admin;

use App\Services\Admin\SupabaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SupabaseServiceTest extends TestCase
{
    public function test_uploadImage_success()
    {
        $file = UploadedFile::fake()->image('test.png');
        Http::fake([
            '*' => Http::response('', 200),
        ]);
        $service = new SupabaseService();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $this->assertTrue($service->uploadImage($file, 'test/path.png'));
    }

    public function test_uploadImage_failure_logs_and_throws()
    {
        $file = UploadedFile::fake()->image('fail.png');
        Http::fake([
            '*' => Http::response('fail', 400),
        ]);
        $service = new SupabaseService();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'Supabase upload failed') && isset($context['response']);
        });
        $this->expectException(\Exception::class);
        $service->uploadImage($file, 'fail/path.png');
    }

    public function test_deleteImage_success()
    {
        Http::fake([
            '*' => Http::response('', 200),
        ]);
        $service = new SupabaseService();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $this->assertNull($service->deleteImage('test/path.png'));
    }

    public function test_deleteImage_failure_logs_and_throws()
    {
        Http::fake([
            '*' => Http::response('fail', 400),
        ]);
        $service = new SupabaseService();
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        Log::shouldReceive('error')->once()->withArgs(function ($msg, $context) {
            return str_contains($msg, 'Supabase delete failed') && isset($context['response']);
        });
        $this->expectException(\Exception::class);
        $service->deleteImage('fail/path.png');
    }
}
