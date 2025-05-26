<?php

use App\Models\User;

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

test('admin can confirm password', function () {
    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($admin)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('user can confirm password', function () {
    $user = \App\Models\User::factory()->create([
        'role' => 'user',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'grade_level' => 5,
        'school' => 'Sample Elementary School',
        'coach_name' => 'Ms. Smith',
    ]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('admin cannot confirm with wrong password', function () {
    $admin = \App\Models\User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($admin)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

test('user cannot confirm with wrong password', function () {
    $user = \App\Models\User::factory()->create([
        'role' => 'user',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'grade_level' => 5,
        'school' => 'Sample Elementary School',
        'coach_name' => 'Ms. Smith',
    ]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
