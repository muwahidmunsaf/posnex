<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can register with valid data', function () {
    $company = \App\Models\Company::factory()->create();
    $data = [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'company_id' => $company->id,
        'status' => 'active',
        'role' => 'admin',
    ];
    $response = $this->post('/register', $data);
    $response->assertRedirect(route('login'));
    $response->assertSessionHas('success', 'Registration successful. Please login.');
    $this->assertDatabaseHas('users', ['email' => $data['email']]);
});

test('registration fails with invalid data', function () {
    $response = $this->post('/register', [
        'name' => '',
        'email' => 'not-an-email',
        'password' => 'short',
        'password_confirmation' => 'different',
        'status' => '',
        'role' => '',
    ]);
    $response->assertSessionHasErrors(['name', 'email', 'password', 'status', 'role']);
});

test('user can login with correct credentials', function () {
    $user = \App\Models\User::factory()->create([
        'password' => bcrypt('password123'),
        'status' => 'active',
        'role' => 'admin',
    ]);
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('login fails with incorrect credentials', function () {
    $user = \App\Models\User::factory()->create([
        'password' => bcrypt('password123'),
        'status' => 'active',
    ]);
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);
    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

test('user can logout and is redirected', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);
    $response = $this->post('/logout');
    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('admin can assign multiple permissions to a user', function () {
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);
    $user = \App\Models\User::factory()->create(['role' => 'employee', 'status' => 'active']);
    $permissions = ['sales', 'inventory', 'reports'];
    $updateData = [
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        'status' => $user->status,
        'company_id' => $user->company_id,
        'permissions' => $permissions,
    ];
    $response = $this->put("/users/{$user->id}", $updateData);
    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        // Permissions are stored as JSON array
        'permissions' => json_encode($permissions),
    ]);
}); 