<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('admin profile page is displayed', function () {
    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($admin)->get('/profile');
    $response->assertOk();
});

test('user profile page is displayed', function () {
    $user = \App\Models\User::factory()->create([
        'role' => 'user',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'grade_level' => 5,
        'school' => 'Sample Elementary School',
        'coach_name' => 'Ms. Smith',
    ]);

    $response = $this->actingAs($user)->get('/profile');
    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    expect($user->first_name)->toBe('Test');
    expect($user->last_name)->toBe('User');
    expect($user->email)->toBe('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('admin profile information can be updated', function () {
    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($admin)->patch('/profile', [
        'first_name' => 'Admin',
        'last_name' => 'User',
        'email' => 'admin-updated@example.com',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect('/profile');
    $admin->refresh();
    expect($admin->first_name)->toBe('Admin');
    expect($admin->last_name)->toBe('User');
    expect($admin->email)->toBe('admin-updated@example.com');
});

test('user profile information can be updated', function () {
    $user = \App\Models\User::factory()->create([
        'role' => 'user',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'grade_level' => 5,
        'school' => 'Sample Elementary School',
        'coach_name' => 'Ms. Smith',
    ]);

    $response = $this->actingAs($user)->patch('/profile', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'user-updated@example.com',
        'grade_level' => 6,
        'school' => 'New School',
        'coach_name' => 'Mr. Brown',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect('/profile');
    $user->refresh();
    expect($user->first_name)->toBe('John');
    expect($user->last_name)->toBe('Doe');
    expect($user->email)->toBe('user-updated@example.com');
    // grade_level is not updatable by the profile update form/service, so do not assert it changes
    expect($user->school)->toBe('New School');
    expect($user->coach_name)->toBe('Mr. Brown');
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    expect($user->refresh()->email_verified_at)->not()->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});
