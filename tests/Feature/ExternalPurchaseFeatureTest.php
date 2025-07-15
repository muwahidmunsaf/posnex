<?php

use App\Models\User;
use App\Models\Company;
use App\Models\ExternalPurchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create an external purchase', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = ExternalPurchase::factory()->make(['company_id' => $company->id])->toArray();
    unset($data['company_id']);
    $response = $this->post('/external-purchases', $data);
    $response->assertRedirect(route('external-purchases.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('external_purchases', ['item_name' => $data['item_name'], 'company_id' => $company->id]);
});

test('external purchase creation fails with invalid data', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/external-purchases', [
        'item_name' => '',
        'purchase_amount' => null,
    ]);
    $response->assertSessionHasErrors(['item_name', 'purchase_amount']);
});

test('admin can update an external purchase', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $externalPurchase = ExternalPurchase::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'item_name' => 'Updated Item',
        'purchase_amount' => 123.45,
        'details' => $externalPurchase->details,
        'purchase_source' => $externalPurchase->purchase_source,
        'date' => now()->toDateString(),
    ];
    $response = $this->put("/external-purchases/{$externalPurchase->id}", $updateData);
    $response->assertRedirect(route('external-purchases.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('external_purchases', ['id' => $externalPurchase->id, 'item_name' => 'Updated Item']);
});

test('admin can delete an external purchase', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $externalPurchase = ExternalPurchase::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/external-purchases/{$externalPurchase->id}");
    $response->assertRedirect(route('external-purchases.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('external_purchases', ['id' => $externalPurchase->id]);
});

test('employee cannot access external purchase CRUD', function () {
    $company = Company::factory()->create();
    $employee = User::factory()->create(['role' => 'employee', 'company_id' => $company->id]);
    $this->actingAs($employee);
    $externalPurchase = ExternalPurchase::factory()->create(['company_id' => $company->id]);
    $response = $this->get('/external-purchases');
    $response->assertForbidden();
    $response = $this->post('/external-purchases', [
        'item_name' => 'Should Fail',
        'purchase_amount' => 100,
    ]);
    $response->assertForbidden();
    $response = $this->put("/external-purchases/{$externalPurchase->id}", ['item_name' => 'Should Fail']);
    $response->assertForbidden();
    $response = $this->delete("/external-purchases/{$externalPurchase->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access external purchase CRUD', function () {
    $externalPurchase = ExternalPurchase::factory()->create();
    $response = $this->get('/external-purchases');
    $response->assertRedirect('/login');
    $response = $this->post('/external-purchases', [
        'item_name' => 'Should Fail',
        'purchase_amount' => 100,
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/external-purchases/{$externalPurchase->id}", ['item_name' => 'Should Fail']);
    $response->assertRedirect('/login');
    $response = $this->delete("/external-purchases/{$externalPurchase->id}");
    $response->assertRedirect('/login');
}); 