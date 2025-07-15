<?php

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create an inventory item', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = [
        'item_name' => 'Test Product',
        'retail_amount' => 100,
        'wholesale_amount' => 80,
        'unit' => 50,
        'details' => 'Test details',
        'status' => 'active',
    ];
    $response = $this->post('/inventory', $data);
    $response->assertRedirect(route('inventory.index'));
    $response->assertSessionHas('success', 'Item added successfully.');
    $this->assertDatabaseHas('inventory', ['item_name' => $data['item_name'], 'company_id' => $company->id]);
});

test('inventory creation fails with invalid data', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/inventory', [
        'item_name' => '',
        'unit' => '',
        'retail_amount' => null,
        'wholesale_amount' => null,
    ]);
    $response->assertSessionHasErrors(['item_name', 'unit', 'retail_amount', 'wholesale_amount']);
});

test('admin can update an inventory item', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'item_name' => 'Updated Item',
        'retail_amount' => $inventory->retail_amount,
        'wholesale_amount' => $inventory->wholesale_amount,
        'unit' => (int) $inventory->unit,
        'details' => $inventory->details,
        'status' => $inventory->status,
    ];
    $response = $this->put("/inventory/{$inventory->id}", $updateData);
    $response->assertRedirect(route('inventory.index'));
    $response->assertSessionHas('success', 'Item updated successfully.');
    $this->assertDatabaseHas('inventory', ['id' => $inventory->id, 'item_name' => 'Updated Item']);
});

test('admin can delete an inventory item', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/inventory/{$inventory->id}");
    $response->assertRedirect();
    $this->assertDatabaseMissing('inventory', ['id' => $inventory->id]);
}); 