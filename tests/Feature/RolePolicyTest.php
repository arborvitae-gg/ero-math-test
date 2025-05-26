<?php
// Policy/authorization tests
use App\Models\User;

test('admin can access admin routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/admin/dashboard');
    $response->assertOk();
});

test('user cannot access admin routes', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);
    $response = $this->get('/admin/dashboard');
    $response->assertForbidden();
});
