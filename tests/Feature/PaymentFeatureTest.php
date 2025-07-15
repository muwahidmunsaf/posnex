<?php

use App\Models\User;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a payment', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);
    $customer = Customer::factory()->create();
    $data = [
        'amount_paid' => 100,
        'customer_id' => $customer->id,
        // Add any other required payment fields as per your controller validation
    ];
    $response = $this->post('/payments/store', $data);
    $response->assertRedirect();
    $this->assertDatabaseHas('payments', ['amount_paid' => 100, 'customer_id' => $customer->id]);
});

test('payment creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);
    $response = $this->post('/payments/store', [
        'amount_paid' => null,
        'customer_id' => null,
    ]);
    $response->assertSessionHasErrors(['amount_paid', 'customer_id']);
}); 