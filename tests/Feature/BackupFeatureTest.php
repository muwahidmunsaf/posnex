<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can trigger a backup and see backup file created', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);
    // Clean up any old backups
    $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
    foreach ($disk->files('Laravel') as $file) {
        if (str_ends_with($file, '.zip')) $disk->delete($file);
    }
    // Trigger backup
    $response = $this->post('/admin/backup');
    $response->assertSessionHas('success');
    // Check that a backup file now exists
    $files = $disk->files('Laravel');
    $zipFiles = array_filter($files, fn($f) => str_ends_with($f, '.zip'));
    expect(count($zipFiles))->toBeGreaterThan(0);
});

// Optionally, scaffold restore test (not run for safety)
test('admin can see list of backups', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);
    $response = $this->get('/admin/backups');
    $response->assertStatus(200);
    $response->assertSee('Application Backups');
}); 