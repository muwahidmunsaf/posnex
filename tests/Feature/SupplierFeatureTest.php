<?php

use App\Models\User;
use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a supplier', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = Supplier::factory()->make(['company_id' => $company->id])->toArray();
    unset($data['company_id']);
    $response = $this->post('/suppliers', $data);
    $response->assertRedirect(route('suppliers.index'));
    $response->assertSessionHas('success', 'Supplier created successfully.');
    $this->assertDatabaseHas('suppliers', ['supplier_name' => $data['supplier_name'], 'company_id' => $company->id]);
});

test('supplier creation fails with invalid data', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/suppliers', [
        'supplier_name' => '',
        'country' => '',
    ]);
    $response->assertSessionHasErrors(['supplier_name', 'country']);
});

test('admin can update a supplier', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $supplier = Supplier::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'supplier_name' => 'Updated Supplier',
        'cell_no' => '03001234567',
        'contact_person' => 'Updated Person',
        'country' => 'Updated Country',
        'company_id' => $company->id,
    ];
    $response = $this->put("/suppliers/{$supplier->id}", $updateData);
    $response->assertRedirect(route('suppliers.index'));
    $response->assertSessionHas('success', 'Supplier updated successfully.');
    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'supplier_name' => 'Updated Supplier', 'country' => 'Updated Country']);
});

test('admin can delete a supplier', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $supplier = Supplier::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/suppliers/{$supplier->id}");
    $response->assertRedirect(route('suppliers.index'));
    $response->assertSessionHas('success', 'Supplier deleted successfully.');
    $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
});

test('employee cannot access supplier CRUD', function () {
    $company = Company::factory()->create();
    $employee = User::factory()->create(['role' => 'employee', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($employee);
    $supplier = Supplier::factory()->create(['company_id' => $company->id]);
    $response = $this->get('/suppliers');
    $response->assertForbidden();
    $response = $this->post('/suppliers', [
        'supplier_name' => 'Should Fail',
        'country' => 'Should Fail',
    ]);
    $response->assertForbidden();
    $response = $this->put("/suppliers/{$supplier->id}", ['supplier_name' => 'Should Fail', 'country' => 'Should Fail']);
    $response->assertForbidden();
    $response = $this->delete("/suppliers/{$supplier->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access supplier CRUD', function () {
    $supplier = Supplier::factory()->create();
    $response = $this->get('/suppliers');
    $response->assertRedirect('/login');
    $response = $this->post('/suppliers', [
        'supplier_name' => 'Should Fail',
        'country' => 'Should Fail',
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/suppliers/{$supplier->id}", ['supplier_name' => 'Should Fail', 'country' => 'Should Fail']);
    $response->assertRedirect('/login');
    $response = $this->delete("/suppliers/{$supplier->id}");
    $response->assertRedirect('/login');
}); 