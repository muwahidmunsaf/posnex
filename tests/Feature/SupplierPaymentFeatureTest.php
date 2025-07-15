<?php

use App\Models\User;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a supplier payment', function () {
    $supplier = Supplier::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = SupplierPayment::factory()->make(['supplier_id' => $supplier->id])->toArray();
    $response = $this->post('/supplier-payments', $data);
    $response->assertRedirect(route('supplier-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('supplier_payments', ['supplier_id' => $supplier->id, 'amount' => $data['amount']]);
});

test('supplier payment creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/supplier-payments', [
        'supplier_id' => null,
        'amount' => null,
        'payment_date' => null,
    ]);
    $response->assertSessionHasErrors(['supplier_id', 'amount', 'payment_date']);
});

test('admin can update a supplier payment', function () {
    $supplier = Supplier::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $payment = SupplierPayment::factory()->create(['supplier_id' => $supplier->id]);
    $this->actingAs($admin);
    $updateData = [
        'supplier_id' => $supplier->id,
        'amount' => 777,
        'payment_method' => 'cash',
        'payment_date' => now()->toDateString(),
        'note' => 'Updated',
        'currency_code' => 'PKR',
        'exchange_rate_to_pkr' => 1.0,
        'pkr_amount' => 777,
    ];
    $response = $this->put("/supplier-payments/{$payment->id}", $updateData);
    $response->assertRedirect(route('supplier-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('supplier_payments', ['id' => $payment->id, 'amount' => 777]);
});

test('admin can delete a supplier payment', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $payment = SupplierPayment::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/supplier-payments/{$payment->id}");
    $response->assertRedirect(route('supplier-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('supplier_payments', ['id' => $payment->id]);
});

test('cannot delete supplier with payments', function () {
    $supplier = Supplier::factory()->create();
    $payment = SupplierPayment::factory()->create(['supplier_id' => $supplier->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->delete("/suppliers/{$supplier->id}");
    // Should either fail or cascade delete depending on business logic
    $this->assertDatabaseHas('supplier_payments', ['id' => $payment->id]);
});

test('employee cannot access supplier payment CRUD', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $payment = SupplierPayment::factory()->create();
    $this->actingAs($employee);
    $response = $this->get('/supplier-payments');
    $response->assertForbidden();
    $response = $this->post('/supplier-payments', [
        'supplier_id' => $payment->supplier_id,
        'amount' => 100,
        'payment_date' => now()->toDateString(),
    ]);
    $response->assertForbidden();
    $response = $this->put("/supplier-payments/{$payment->id}", ['amount' => 100]);
    $response->assertForbidden();
    $response = $this->delete("/supplier-payments/{$payment->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access supplier payment CRUD', function () {
    $payment = SupplierPayment::factory()->create();
    $response = $this->get('/supplier-payments');
    $response->assertRedirect('/login');
    $response = $this->post('/supplier-payments', [
        'supplier_id' => $payment->supplier_id,
        'amount' => 100,
        'payment_date' => now()->toDateString(),
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/supplier-payments/{$payment->id}", ['amount' => 100]);
    $response->assertRedirect('/login');
    $response = $this->delete("/supplier-payments/{$payment->id}");
    $response->assertRedirect('/login');
}); 