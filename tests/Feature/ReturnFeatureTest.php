<?php

use App\Models\User;
use App\Models\Sale;
use App\Models\ReturnTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a return transaction', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $sale = Sale::factory()->create(['company_id' => $company->id]);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $data = [
        'sale_id' => $sale->id,
        'item_id' => $inventory->id,
        'quantity' => 2,
        'amount' => 50,
        'reason' => 'Customer request',
    ];
    $response = $this->post('/returns', $data);
    $response->assertRedirect();
    $this->assertDatabaseHas('return_transactions', ['sale_id' => $sale->id, 'amount' => 50]);
});

test('return creation fails with invalid data', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/returns', [
        'sale_id' => null,
        'amount' => null,
    ]);
    $response->assertSessionHasErrors(['sale_id', 'amount']);
});

test('returns index page loads', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get('/returns');
    $response->assertOk();
}); 