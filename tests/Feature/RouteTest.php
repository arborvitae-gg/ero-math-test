<?php
// Route access tests
use App\Models\User;

test('guest is redirected to login for protected routes', function () {
    $response = $this->get('/profile');
    $response->assertRedirect('/login');
});

test('admin can access admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/admin/dashboard');
    $response->assertOk();
});

test('user cannot access admin dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);
    $response = $this->get('/admin/dashboard');
    $response->assertForbidden();
});
