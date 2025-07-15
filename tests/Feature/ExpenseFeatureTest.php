<?php

use App\Models\User;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create an expense', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = \App\Models\Expense::factory()->make(['company_id' => $company->id])->toArray();
    unset($data['company_id']);
    $response = $this->post('/expenses', $data);
    $response->assertRedirect();
    $this->assertDatabaseHas('expenses', ['purpose' => $data['purpose'], 'company_id' => $company->id]);
});

test('expense creation fails with invalid data', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/expenses', [
        'purpose' => '',
        'amount' => null,
        'paidBy' => '',
        'paymentWay' => '',
    ]);
    $response->assertSessionHasErrors(['purpose', 'amount', 'paidBy', 'paymentWay']);
}); 