<?php

uses(\Tests\TestCase::class);

// Unit test for ProfileService
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\Request;

it('updates user profile', function () {
    $user = User::factory()->create();
    $service = new ProfileService();
    $service->updateProfile($user, [
        'first_name' => 'Updated',
        'last_name' => 'User',
        'email' => 'updated@example.com',
    ]);
    $user->refresh();
    expect($user->first_name)->toBe('Updated');
    expect($user->email)->toBe('updated@example.com');
});

it('deletes user account', function () {
    $user = User::factory()->create();
    $service = new ProfileService();
    $request = new Request();
    $request->setLaravelSession(app('session.store'));
    $service->deleteProfile($user, $request);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
