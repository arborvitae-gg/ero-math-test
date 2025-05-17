<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseService
{
    protected string $url;
    protected string $key;
    protected string $bucket;

    public function __construct()
    {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
        $this->bucket = config('services.supabase.bucket');
    }

    public function uploadImage(UploadedFile $file, string $path): bool
    {
        $response = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Content-Type' => $file->getMimeType(),
        ])->withBody(
            $file->get(),
            $file->getMimeType()
        )->put(
            "{$this->url}/storage/v1/object/{$this->bucket}/{$path}"
        );

        if (!$response->successful()) {
            Log::error('Supabase upload failed', ['response' => $response->body()]);
            throw new \Exception('Failed to upload image: ' . $response->body());
        }

        return true;
    }

    public function deleteImage(string $path): void
    {
        $response = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
        ])->delete("{$this->url}/storage/v1/object/{$this->bucket}/{$path}");

        if (!$response->successful()) {
            Log::error('Supabase delete failed', ['response' => $response->body()]);
            throw new \Exception('Failed to delete image: ' . $response->body());
        }
    }
}
