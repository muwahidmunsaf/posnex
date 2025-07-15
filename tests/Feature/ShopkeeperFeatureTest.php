<?php

use App\Models\User;
use App\Models\Distributor;
use App\Models\Shopkeeper;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a shopkeeper', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $data = [
        'distributor_id' => $distributor->id,
        'name' => 'Test Shopkeeper',
        'phone' => '1234567890',
        'address' => 'Test Address',
        'remaining_amount' => 1000,
    ];
    $response = $this->post('/shopkeepers', $data);
    $response->assertRedirect(route('shopkeepers.index', ['distributor_id' => $distributor->id]));
    $response->assertSessionHas('success', 'Shopkeeper added successfully.');
    $this->assertDatabaseHas('shopkeepers', ['name' => 'Test Shopkeeper', 'distributor_id' => $distributor->id]);
});

test('shopkeeper creation fails with invalid data', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/shopkeepers', [
        'distributor_id' => null,
        'name' => '',
    ]);
    $response->assertSessionHasErrors(['distributor_id', 'name']);
});

test('admin can update a shopkeeper', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $updateData = [
        'distributor_id' => $distributor->id,
        'name' => 'Updated Shopkeeper',
        'phone' => $shopkeeper->phone,
        'address' => $shopkeeper->address,
        'remaining_amount' => 500,
    ];
    $response = $this->put("/shopkeepers/{$shopkeeper->id}", $updateData);
    $response->assertRedirect(route('shopkeepers.index', ['distributor_id' => $distributor->id]));
    $response->assertSessionHas('success', 'Shopkeeper updated successfully.');
    $this->assertDatabaseHas('shopkeepers', ['id' => $shopkeeper->id, 'name' => 'Updated Shopkeeper', 'remaining_amount' => 500]);
});

test('admin can delete a shopkeeper', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $response = $this->delete("/shopkeepers/{$shopkeeper->id}");
    $response->assertRedirect(route('shopkeepers.index', ['distributor_id' => $distributor->id]));
    $response->assertSessionHas('success', 'Shopkeeper deleted successfully.');
    $this->assertDatabaseMissing('shopkeepers', ['id' => $shopkeeper->id]);
});

test('shopkeeper index shows distributor association and outstanding', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id, 'remaining_amount' => 200]);
    $response = $this->get('/shopkeepers?distributor_id=' . $distributor->id);
    $response->assertStatus(200);
    $response->assertSee($shopkeeper->name);
    $response->assertSee($distributor->name);
    $response->assertSee('200');
});

test('employee cannot access shopkeeper CRUD', function () {
    $company = \App\Models\Company::factory()->create();
    $employee = \App\Models\User::factory()->create(['role' => 'employee', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($employee);
    $distributor = \App\Models\Distributor::factory()->create(['company_id' => $company->id]);
    $shopkeeper = \App\Models\Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $response = $this->get('/shopkeepers');
    $response->assertForbidden();
    $response = $this->post('/shopkeepers', [
        'distributor_id' => $distributor->id,
        'name' => 'Should Fail',
    ]);
    $response->assertForbidden();
    $response = $this->put("/shopkeepers/{$shopkeeper->id}", ['name' => 'Should Fail', 'distributor_id' => $distributor->id]);
    $response->assertForbidden();
    $response = $this->delete("/shopkeepers/{$shopkeeper->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access shopkeeper CRUD', function () {
    $distributor = \App\Models\Distributor::factory()->create();
    $shopkeeper = \App\Models\Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $response = $this->get('/shopkeepers');
    $response->assertRedirect('/login');
    $response = $this->post('/shopkeepers', [
        'distributor_id' => $distributor->id,
        'name' => 'Should Fail',
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/shopkeepers/{$shopkeeper->id}", ['name' => 'Should Fail', 'distributor_id' => $distributor->id]);
    $response->assertRedirect('/login');
    $response = $this->delete("/shopkeepers/{$shopkeeper->id}");
    $response->assertRedirect('/login');
});

test('admin and employee can access POS (sales/create)', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $employee = \App\Models\User::factory()->create(['role' => 'employee', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get('/sales/create');
    $response->assertStatus(200);
    $this->actingAs($employee);
    $response = $this->get('/sales/create');
    $response->assertStatus(200);
}); 