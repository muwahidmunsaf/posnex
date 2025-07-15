<?php

use App\Models\User;
use App\Models\Distributor;
use App\Models\Inventory;
use App\Models\DistributorProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a distributor product', function () {
    $distributor = Distributor::factory()->create();
    $inventory = Inventory::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = DistributorProduct::factory()->make(['distributor_id' => $distributor->id, 'inventory_id' => $inventory->id])->toArray();
    $response = $this->post('/distributor-products', $data);
    $response->assertRedirect(route('distributor-products.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('distributor_products', ['distributor_id' => $distributor->id, 'inventory_id' => $inventory->id]);
});

test('distributor product creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/distributor-products', [
        'distributor_id' => null,
        'inventory_id' => null,
        'quantity_assigned' => null,
    ]);
    $response->assertSessionHasErrors(['distributor_id', 'inventory_id', 'quantity_assigned']);
});

test('admin can update a distributor product', function () {
    $distributor = Distributor::factory()->create();
    $inventory = Inventory::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $product = DistributorProduct::factory()->create(['distributor_id' => $distributor->id, 'inventory_id' => $inventory->id]);
    $this->actingAs($admin);
    $updateData = [
        'distributor_id' => $distributor->id,
        'inventory_id' => $inventory->id,
        'quantity_assigned' => 100,
        'quantity_remaining' => 50,
        'unit_price' => 123.45,
        'total_value' => 12345,
        'assignment_date' => now()->toDateString(),
        'status' => 'active',
        'notes' => 'Updated',
        'assignment_number' => 'ASSIGN123',
    ];
    $response = $this->put("/distributor-products/{$product->id}", $updateData);
    $response->assertRedirect(route('distributor-products.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('distributor_products', ['id' => $product->id, 'quantity_assigned' => 100, 'status' => 'active']);
});

test('admin can delete a distributor product', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $product = DistributorProduct::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/distributor-products/{$product->id}");
    $response->assertRedirect(route('distributor-products.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('distributor_products', ['id' => $product->id]);
});

test('cannot delete distributor with products', function () {
    $distributor = Distributor::factory()->create();
    $product = DistributorProduct::factory()->create(['distributor_id' => $distributor->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->delete("/distributors/{$distributor->id}");
    // Should either fail or cascade delete depending on business logic
    $this->assertDatabaseHas('distributor_products', ['id' => $product->id]);
});

test('employee cannot access distributor product CRUD', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $product = DistributorProduct::factory()->create();
    $this->actingAs($employee);
    $response = $this->get('/distributor-products');
    $response->assertForbidden();
    $response = $this->post('/distributor-products', [
        'distributor_id' => $product->distributor_id,
        'inventory_id' => $product->inventory_id,
        'quantity_assigned' => 10,
    ]);
    $response->assertForbidden();
    $response = $this->put("/distributor-products/{$product->id}", ['quantity_assigned' => 10]);
    $response->assertForbidden();
    $response = $this->delete("/distributor-products/{$product->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access distributor product CRUD', function () {
    $product = DistributorProduct::factory()->create();
    $response = $this->get('/distributor-products');
    $response->assertRedirect('/login');
    $response = $this->post('/distributor-products', [
        'distributor_id' => $product->distributor_id,
        'inventory_id' => $product->inventory_id,
        'quantity_assigned' => 10,
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/distributor-products/{$product->id}", ['quantity_assigned' => 10]);
    $response->assertRedirect('/login');
    $response = $this->delete("/distributor-products/{$product->id}");
    $response->assertRedirect('/login');
}); 