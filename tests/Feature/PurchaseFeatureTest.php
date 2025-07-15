<?php

use App\Models\User;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a purchase', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $supplier = \App\Models\Supplier::factory()->create(['company_id' => $company->id]);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $data = [
        'supplier_id' => $supplier->id,
        'purchase_date' => now()->toDateString(),
        'items' => [
            [
                'inventory_id' => $inventory->id,
                'quantity' => 5,
                'purchase_amount' => 150.0,
            ],
        ],
    ];
    $token = 'test-purchase-token-create';
    session(['purchase_idempotency_token' => $token]);
    $data['idempotency_token'] = $token;
    $response = $this->post('/purchase', $data);
    $response->assertRedirect(route('purchase.print', 1)); // The id may vary, but print is the redirect
    $this->assertDatabaseHas('purchases', ['supplier_id' => $supplier->id, 'company_id' => $company->id]);
});

test('purchase creation fails with invalid data', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $token = 'test-purchase-token-invalid';
    session(['purchase_idempotency_token' => $token]);
    $response = $this->post('/purchase', [
        'supplier_id' => null,
        'purchase_date' => null,
        'items' => [],
        'idempotency_token' => $token,
    ]);
    $response->assertSessionHasErrors(['supplier_id', 'purchase_date']);
});

test('admin can update a purchase', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $supplier = \App\Models\Supplier::factory()->create(['company_id' => $company->id]);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $purchase = \App\Models\Purchase::factory()->create(['supplier_id' => $supplier->id, 'company_id' => $company->id]);
    $updateData = [
        'supplier_id' => $supplier->id,
        'purchase_date' => now()->toDateString(),
        'items' => [
            [
                'inventory_id' => $inventory->id,
                'quantity' => 10,
                'purchase_amount' => 200,
            ],
        ],
    ];
    $response = $this->put("/purchase/{$purchase->id}", $updateData);
    $response->assertRedirect(route('purchase.index'));
    $response->assertSessionHas('success', 'Purchase updated successfully.');
    $this->assertDatabaseHas('purchases', ['id' => $purchase->id, 'supplier_id' => $supplier->id]);
});

test('admin can delete a purchase', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $purchase = \App\Models\Purchase::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/purchase/{$purchase->id}");
    $response->assertRedirect(route('purchase.index'));
    $response->assertSessionHas('success', 'Purchase deleted successfully.');
    $this->assertDatabaseMissing('purchases', ['id' => $purchase->id]);
}); 