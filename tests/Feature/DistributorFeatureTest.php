<?php

use App\Models\User;
use App\Models\Distributor;
use App\Models\Company;
use App\Models\Shopkeeper;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a distributor', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = [
        'name' => 'Test Distributor',
        'phone' => '1234567890',
        'address' => 'Test Address',
        'commission_rate' => 5,
    ];
    $response = $this->post('/distributors', $data);
    $response->assertRedirect(route('distributors.index'));
    $response->assertSessionHas('success', 'Distributor added successfully.');
    $this->assertDatabaseHas('distributors', ['name' => 'Test Distributor', 'company_id' => $company->id]);
});

test('distributor creation fails with invalid data', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/distributors', [
        'name' => '',
        'commission_rate' => 'not-a-number',
    ]);
    $response->assertSessionHasErrors(['name', 'commission_rate']);
});

test('admin can update a distributor', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'name' => 'Updated Distributor',
        'phone' => $distributor->phone,
        'address' => $distributor->address,
        'commission_rate' => 10,
    ];
    $response = $this->put("/distributors/{$distributor->id}", $updateData);
    $response->assertRedirect(route('distributors.index'));
    $response->assertSessionHas('success', 'Distributor updated successfully.');
    $this->assertDatabaseHas('distributors', ['id' => $distributor->id, 'name' => 'Updated Distributor', 'commission_rate' => 10]);
});

test('admin can delete a distributor', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/distributors/{$distributor->id}");
    $response->assertRedirect(route('distributors.index'));
    $response->assertSessionHas('success', 'Distributor deleted successfully.');
    $this->assertDatabaseMissing('distributors', ['id' => $distributor->id]);
});

test('distributor index shows shopkeeper association and commission', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id, 'commission_rate' => 10]);
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $response = $this->get('/distributors');
    $response->assertStatus(200);
    $response->assertSee($distributor->name);
    $response->assertSee((string) $distributor->commission_rate);
    $response->assertSee($shopkeeper->name);
}); 