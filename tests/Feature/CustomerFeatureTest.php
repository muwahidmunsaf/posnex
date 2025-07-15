<?php

use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a customer', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = \App\Models\Customer::factory()->make(['company_id' => $company->id, 'type' => 'wholesale'])->toArray();
    unset($data['company_id']);
    $response = $this->post('/customers', $data);
    $response->assertRedirect(route('customers.index'));
    $response->assertSessionHas('success', 'Customer created successfully.');
    $this->assertDatabaseHas('customers', ['name' => $data['name'], 'type' => 'wholesale']);
});

test('admin can update a customer', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $customer = \App\Models\Customer::factory()->create(['company_id' => $company->id, 'type' => 'wholesale']);
    $newName = 'Updated Name';
    $updateData = array_merge($customer->toArray(), ['name' => $newName, 'type' => 'wholesale']);
    unset($updateData['company_id']);
    $response = $this->put("/customers/{$customer->id}", $updateData);
    $response->assertRedirect(route('customers.index'));
    $response->assertSessionHas('success', 'Customer updated successfully.');
    $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => $newName]);
});

test('admin can delete a customer', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $customer = \App\Models\Customer::factory()->create(['company_id' => $company->id, 'type' => 'wholesale']);
    $response = $this->delete("/customers/{$customer->id}");
    $response->assertRedirect(route('customers.index'));
    $response->assertSessionHas('success', 'Customer deleted successfully.');
    $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
}); 