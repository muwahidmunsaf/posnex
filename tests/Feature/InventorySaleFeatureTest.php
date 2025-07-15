<?php

use App\Models\User;
use App\Models\Sale;
use App\Models\Inventory;
use App\Models\InventorySale;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create an inventory sale', function () {
    $sale = Sale::factory()->create();
    $inventory = Inventory::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = InventorySale::factory()->make(['sale_id' => $sale->id, 'item_id' => $inventory->id])->toArray();
    $response = $this->post('/inventory-sales', $data);
    $response->assertRedirect(route('inventory-sales.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('inventory_sales', ['sale_id' => $sale->id, 'item_id' => $inventory->id]);
});

test('inventory sale creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/inventory-sales', [
        'sale_id' => null,
        'item_id' => null,
        'quantity' => null,
    ]);
    $response->assertSessionHasErrors(['sale_id', 'item_id', 'quantity']);
});

test('admin can update an inventory sale', function () {
    $sale = Sale::factory()->create();
    $inventory = Inventory::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $invSale = InventorySale::factory()->create(['sale_id' => $sale->id, 'item_id' => $inventory->id]);
    $this->actingAs($admin);
    $updateData = [
        'sale_id' => $sale->id,
        'item_id' => $inventory->id,
        'quantity' => 99,
        'sale_type' => $invSale->sale_type,
        'amount' => 123.45,
        'total_amount' => 12345,
        'company_id' => $invSale->company_id,
    ];
    $response = $this->put("/inventory-sales/{$invSale->id}", $updateData);
    $response->assertRedirect(route('inventory-sales.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('inventory_sales', ['id' => $invSale->id, 'quantity' => 99]);
});

test('admin can delete an inventory sale', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $invSale = InventorySale::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/inventory-sales/{$invSale->id}");
    $response->assertRedirect(route('inventory-sales.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('inventory_sales', ['id' => $invSale->id]);
});

test('cannot delete sale with inventory sales', function () {
    $sale = Sale::factory()->create();
    $invSale = InventorySale::factory()->create(['sale_id' => $sale->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->delete("/sales/{$sale->id}");
    // Should either fail or cascade delete depending on business logic
    $this->assertDatabaseHas('inventory_sales', ['id' => $invSale->id]);
});

test('employee cannot access inventory sale CRUD', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $invSale = InventorySale::factory()->create();
    $this->actingAs($employee);
    $response = $this->get('/inventory-sales');
    $response->assertForbidden();
    $response = $this->post('/inventory-sales', [
        'sale_id' => $invSale->sale_id,
        'item_id' => $invSale->item_id,
        'quantity' => 10,
    ]);
    $response->assertForbidden();
    $response = $this->put("/inventory-sales/{$invSale->id}", ['quantity' => 10]);
    $response->assertForbidden();
    $response = $this->delete("/inventory-sales/{$invSale->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access inventory sale CRUD', function () {
    $invSale = InventorySale::factory()->create();
    $response = $this->get('/inventory-sales');
    $response->assertRedirect('/login');
    $response = $this->post('/inventory-sales', [
        'sale_id' => $invSale->sale_id,
        'item_id' => $invSale->item_id,
        'quantity' => 10,
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/inventory-sales/{$invSale->id}", ['quantity' => 10]);
    $response->assertRedirect('/login');
    $response = $this->delete("/inventory-sales/{$invSale->id}");
    $response->assertRedirect('/login');
}); 