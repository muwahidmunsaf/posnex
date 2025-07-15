<?php

use App\Models\User;
use App\Models\Inventory;
use App\Models\Salary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('admin can bulk delete inventory items', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $items = Inventory::factory()->count(3)->create();
    $ids = $items->pluck('id')->toArray();
    $response = $this->post('/inventory/bulk-delete', ['ids' => $ids]);
    $response->assertRedirect(route('inventory.index'));
    foreach ($ids as $id) {
        $this->assertDatabaseMissing('inventory', ['id' => $id]);
    }
});

test('admin can import inventory from excel', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $file = UploadedFile::fake()->create('inventory.xlsx');
    $response = $this->post('/inventory/import-excel', ['file' => $file]);
    $response->assertRedirect(route('inventory.index'));
});

test('admin can export inventory to excel', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/inventory/export-excel');
    $response->assertOk();
    $response->assertHeader('content-disposition');
});

test('admin can bulk pay salaries', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $salaries = Salary::factory()->count(2)->create();
    $ids = $salaries->pluck('id')->toArray();
    $response = $this->post('/salaries/bulk-pay', ['ids' => $ids, 'amount' => 1000]);
    $response->assertRedirect();
}); 