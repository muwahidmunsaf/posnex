<?php

use App\Models\User;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a sale', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $customer = \App\Models\Customer::factory()->create(['company_id' => $company->id, 'type' => 'wholesale']);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $data = [
        'items' => [
            [
                'inventory_id' => $inventory->id,
                'quantity' => 2,
            ],
        ],
        'payment_method' => 'cash',
        'sale_type' => 'wholesale',
        'wholesale_customer_id' => $customer->id,
        'discount' => 0,
        'amount_received' => 200,
        'change_return' => 0,
    ];
    $token = 'test-sale-token-create';
    session(['sale_idempotency_token' => $token]);
    $data['idempotency_token'] = $token;
    $response = $this->post('/sales', $data);
    $response->assertStatus(200); // Controller renders invoice view
    $this->assertDatabaseHas('sales', ['sale_type' => 'wholesale', 'customer_id' => $customer->id]);
});

test('sale creation fails with invalid data', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/sales', [
        'items' => [],
        'payment_method' => '',
        'sale_type' => '',
    ]);
    $response->assertSessionHasErrors();
});

test('admin can update a sale', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $sale = \App\Models\Sale::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'payment_method' => 'cash',
        'discount' => 10,
        'amount_received' => 100,
        'change_return' => 0,
    ];
    $response = $this->put("/sales/{$sale->id}", $updateData);
    $response->assertRedirect(route('sales.index'));
    $response->assertSessionHas('success', 'Sale updated successfully.');
    $this->assertDatabaseHas('sales', ['id' => $sale->id, 'discount' => 10]);
});

test('admin can delete a sale', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $sale = \App\Models\Sale::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/sales/{$sale->id}");
    $response->assertRedirect(route('sales.index'));
    $response->assertSessionHas('success', 'Sale deleted successfully.');
    $this->assertDatabaseMissing('sales', ['id' => $sale->id]);
}); 