<?php

use App\Models\User;
use App\Models\Distributor;
use App\Models\DistributorPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a distributor payment', function () {
    $distributor = Distributor::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = DistributorPayment::factory()->make(['distributor_id' => $distributor->id])->toArray();
    $response = $this->post('/distributor-payments', $data);
    $response->assertRedirect(route('distributor-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('distributor_payments', ['distributor_id' => $distributor->id, 'amount' => $data['amount']]);
});

test('distributor payment creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/distributor-payments', [
        'distributor_id' => null,
        'amount' => null,
        'payment_date' => null,
    ]);
    $response->assertSessionHasErrors(['distributor_id', 'amount', 'payment_date']);
});

test('admin can update a distributor payment', function () {
    $distributor = Distributor::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $payment = DistributorPayment::factory()->create(['distributor_id' => $distributor->id]);
    $this->actingAs($admin);
    $updateData = [
        'distributor_id' => $distributor->id,
        'amount' => 888,
        'type' => $payment->type,
        'description' => 'Updated',
        'payment_date' => now()->toDateString(),
        'status' => 'completed',
        'reference_no' => 'REF123',
    ];
    $response = $this->put("/distributor-payments/{$payment->id}", $updateData);
    $response->assertRedirect(route('distributor-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('distributor_payments', ['id' => $payment->id, 'amount' => 888, 'status' => 'completed']);
});

test('admin can delete a distributor payment', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $payment = DistributorPayment::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/distributor-payments/{$payment->id}");
    $response->assertRedirect(route('distributor-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('distributor_payments', ['id' => $payment->id]);
});

test('cannot delete distributor with payments', function () {
    $distributor = Distributor::factory()->create();
    $payment = DistributorPayment::factory()->create(['distributor_id' => $distributor->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->delete("/distributors/{$distributor->id}");
    // Should either fail or cascade delete depending on business logic
    $this->assertDatabaseHas('distributor_payments', ['id' => $payment->id]);
});

test('employee cannot access distributor payment CRUD', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $payment = DistributorPayment::factory()->create();
    $this->actingAs($employee);
    $response = $this->get('/distributor-payments');
    $response->assertForbidden();
    $response = $this->post('/distributor-payments', [
        'distributor_id' => $payment->distributor_id,
        'amount' => 100,
        'payment_date' => now()->toDateString(),
    ]);
    $response->assertForbidden();
    $response = $this->put("/distributor-payments/{$payment->id}", ['amount' => 100]);
    $response->assertForbidden();
    $response = $this->delete("/distributor-payments/{$payment->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access distributor payment CRUD', function () {
    $payment = DistributorPayment::factory()->create();
    $response = $this->get('/distributor-payments');
    $response->assertRedirect('/login');
    $response = $this->post('/distributor-payments', [
        'distributor_id' => $payment->distributor_id,
        'amount' => 100,
        'payment_date' => now()->toDateString(),
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/distributor-payments/{$payment->id}", ['amount' => 100]);
    $response->assertRedirect('/login');
    $response = $this->delete("/distributor-payments/{$payment->id}");
    $response->assertRedirect('/login');
}); 