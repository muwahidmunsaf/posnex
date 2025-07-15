<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can trigger a backup', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/admin/backup');
    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('admin can list backups', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/admin/backups');
    $response->assertStatus(200);
    $response->assertSee('Backup');
});

test('admin can restore a backup', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    // Simulate a backup file name
    $file = 'dummy-backup.zip';
    $response = $this->post('/admin/restore', ['file' => $file]);
    $response->assertRedirect();
});

test('admin can download a backup', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $file = 'dummy-backup.zip';
    $response = $this->get("/admin/backup/download/{$file}");
    $response->assertStatus(200);
    $response->assertHeader('content-disposition');
}); 