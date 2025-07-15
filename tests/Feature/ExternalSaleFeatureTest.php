<?php

use App\Models\User;
use App\Models\Company;
use App\Models\ExternalSale;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create an external sale', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = ExternalSale::factory()->make(['company_id' => $company->id])->toArray();
    unset($data['company_id']);
    $response = $this->post('/external-sales', $data);
    $response->assertRedirect(route('external-sales.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('external_sales', ['sale_amount' => $data['sale_amount'], 'company_id' => $company->id]);
});

test('external sale creation fails with invalid data', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/external-sales', [
        'sale_amount' => null,
        'payment_method' => '',
    ]);
    $response->assertSessionHasErrors(['sale_amount', 'payment_method']);
});

test('admin can update an external sale', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $externalSale = ExternalSale::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'sale_amount' => 555.55,
        'payment_method' => 'cash',
        'tax_amount' => $externalSale->tax_amount,
        'total_amount' => $externalSale->total_amount,
        'date' => now()->toDateString(),
    ];
    $response = $this->put("/external-sales/{$externalSale->id}", $updateData);
    $response->assertRedirect(route('external-sales.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('external_sales', ['id' => $externalSale->id, 'sale_amount' => 555.55]);
});

test('admin can delete an external sale', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $externalSale = ExternalSale::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/external-sales/{$externalSale->id}");
    $response->assertRedirect(route('external-sales.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('external_sales', ['id' => $externalSale->id]);
});

test('employee cannot access external sale CRUD', function () {
    $company = Company::factory()->create();
    $employee = User::factory()->create(['role' => 'employee', 'company_id' => $company->id]);
    $this->actingAs($employee);
    $externalSale = ExternalSale::factory()->create(['company_id' => $company->id]);
    $response = $this->get('/external-sales');
    $response->assertForbidden();
    $response = $this->post('/external-sales', [
        'sale_amount' => 100,
        'payment_method' => 'cash',
    ]);
    $response->assertForbidden();
    $response = $this->put("/external-sales/{$externalSale->id}", ['sale_amount' => 100]);
    $response->assertForbidden();
    $response = $this->delete("/external-sales/{$externalSale->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access external sale CRUD', function () {
    $externalSale = ExternalSale::factory()->create();
    $response = $this->get('/external-sales');
    $response->assertRedirect('/login');
    $response = $this->post('/external-sales', [
        'sale_amount' => 100,
        'payment_method' => 'cash',
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/external-sales/{$externalSale->id}", ['sale_amount' => 100]);
    $response->assertRedirect('/login');
    $response = $this->delete("/external-sales/{$externalSale->id}");
    $response->assertRedirect('/login');
}); 