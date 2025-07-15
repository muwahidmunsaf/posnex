<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can view profile', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/profile');
    $response->assertStatus(200);
    $response->assertSee('profile'); // Adjust as needed for your view
});

test('authenticated user can update profile', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $updateData = [
        'name' => 'Updated Name',
        'email' => $user->email,
        // Add other profile fields as needed
    ];
    $response = $this->post('/profile', $updateData);
    $response->assertRedirect();
    $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
}); 