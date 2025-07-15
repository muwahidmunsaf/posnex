<?php

use App\Models\User;
use App\Models\Purchase;
use App\Models\Inventory;
use App\Models\PurchaseItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a purchase item', function () {
    $purchase = Purchase::factory()->create();
    $inventory = Inventory::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = PurchaseItem::factory()->make(['purchase_id' => $purchase->id, 'inventory_id' => $inventory->id])->toArray();
    $response = $this->post('/purchase-items', $data);
    $response->assertRedirect(route('purchase-items.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('purchase_items', ['purchase_id' => $purchase->id, 'inventory_id' => $inventory->id]);
});

test('purchase item creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/purchase-items', [
        'purchase_id' => null,
        'inventory_id' => null,
        'quantity' => null,
    ]);
    $response->assertSessionHasErrors(['purchase_id', 'inventory_id', 'quantity']);
});

test('admin can update a purchase item', function () {
    $purchase = Purchase::factory()->create();
    $inventory = Inventory::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $item = PurchaseItem::factory()->create(['purchase_id' => $purchase->id, 'inventory_id' => $inventory->id]);
    $this->actingAs($admin);
    $updateData = [
        'purchase_id' => $purchase->id,
        'inventory_id' => $inventory->id,
        'quantity' => 99,
        'purchase_amount' => 123.45,
        'company_id' => $item->company_id,
    ];
    $response = $this->put("/purchase-items/{$item->id}", $updateData);
    $response->assertRedirect(route('purchase-items.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('purchase_items', ['id' => $item->id, 'quantity' => 99]);
});

test('admin can delete a purchase item', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $item = PurchaseItem::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/purchase-items/{$item->id}");
    $response->assertRedirect(route('purchase-items.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('purchase_items', ['id' => $item->id]);
});

test('cannot delete purchase with items', function () {
    $purchase = Purchase::factory()->create();
    $item = PurchaseItem::factory()->create(['purchase_id' => $purchase->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->delete("/purchase/{$purchase->id}");
    // Should either fail or cascade delete depending on business logic
    $this->assertDatabaseHas('purchase_items', ['id' => $item->id]);
});

test('employee cannot access purchase item CRUD', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $item = PurchaseItem::factory()->create();
    $this->actingAs($employee);
    $response = $this->get('/purchase-items');
    $response->assertForbidden();
    $response = $this->post('/purchase-items', [
        'purchase_id' => $item->purchase_id,
        'inventory_id' => $item->inventory_id,
        'quantity' => 10,
    ]);
    $response->assertForbidden();
    $response = $this->put("/purchase-items/{$item->id}", ['quantity' => 10]);
    $response->assertForbidden();
    $response = $this->delete("/purchase-items/{$item->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access purchase item CRUD', function () {
    $item = PurchaseItem::factory()->create();
    $response = $this->get('/purchase-items');
    $response->assertRedirect('/login');
    $response = $this->post('/purchase-items', [
        'purchase_id' => $item->purchase_id,
        'inventory_id' => $item->inventory_id,
        'quantity' => 10,
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/purchase-items/{$item->id}", ['quantity' => 10]);
    $response->assertRedirect('/login');
    $response = $this->delete("/purchase-items/{$item->id}");
    $response->assertRedirect('/login');
}); 