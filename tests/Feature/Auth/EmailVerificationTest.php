<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('admin email can be verified', function () {
    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
        'email_verified_at' => null,
        'password' => bcrypt('password'),
    ]);

    \Illuminate\Support\Facades\Event::fake();

    $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $admin->id, 'hash' => sha1($admin->email)]
    );

    $response = $this->actingAs($admin)->get($verificationUrl);

    \Illuminate\Support\Facades\Event::assertDispatched(\Illuminate\Auth\Events\Verified::class);
    expect($admin->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('user email can be verified', function () {
    $user = \App\Models\User::factory()->create([
        'role' => 'user',
        'email' => 'user@example.com',
        'email_verified_at' => null,
        'password' => bcrypt('password'),
        'grade_level' => 5,
        'school' => 'Sample Elementary School',
        'coach_name' => 'Ms. Smith',
    ]);

    \Illuminate\Support\Facades\Event::fake();

    $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    \Illuminate\Support\Facades\Event::assertDispatched(\Illuminate\Auth\Events\Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
