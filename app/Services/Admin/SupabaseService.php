<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * Service for handling Supabase storage operations (image upload/delete).
 *
 * @package App\Services\Admin
 */
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

    /**
     * Upload an image to Supabase storage.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return void
     * @throws \Exception
     */
    public function uploadImage(UploadedFile $file, string $path): void
    {
        try {
            \Log::info('Starting Supabase image upload', [
                'file_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            $fileContent = file_get_contents($file->getRealPath());
            if ($fileContent === false) {
                throw new \Exception('Failed to read file contents');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type' => $file->getMimeType(),
                'x-upsert' => 'true'
            ])->put(
                "{$this->url}/storage/v1/object/{$this->bucket}/{$path}",
                $fileContent
            );

            \Log::info('Supabase upload response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to upload image to Supabase: ' . $response->body());
            }
        }
        catch (\Throwable $e) {
            \Log::error('Supabase image upload failed', [
                'file' => $file->getClientOriginalName(),
                'path' => $path,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Delete an image from Supabase storage.
     *
     * @param string $path
     * @return void
     * @throws \Exception
     */
    public function deleteImage(string $path): void
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            throw new \Exception('Only admins can perform this action.');
        }
        $response = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
        ])->delete("{$this->url}/storage/v1/object/{$this->bucket}/{$path}");

        if (!$response->successful()) {
            Log::error('Supabase delete failed', [
                'response' => $response->body()
            ]);
            throw new \Exception('Failed to delete image: ' . $response->body());
        }
    }
}
