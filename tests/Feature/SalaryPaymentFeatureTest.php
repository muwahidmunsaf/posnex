<?php

use App\Models\User;
use App\Models\Employee;
use App\Models\SalaryPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a salary payment', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $employee = Employee::factory()->create();
    $this->actingAs($admin);
    $data = SalaryPayment::factory()->make(['employee_id' => $employee->id])->toArray();
    $response = $this->post('/salary-payments', $data);
    $response->assertRedirect(route('salary-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('salary_payments', ['employee_id' => $employee->id, 'amount' => $data['amount']]);
});

test('salary payment creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $this->actingAs($admin);
    $response = $this->post('/salary-payments', [
        'employee_id' => null,
        'amount' => null,
        'date' => null,
    ]);
    $response->assertSessionHasErrors(['employee_id', 'amount', 'date']);
});

test('admin can update a salary payment', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $employee = Employee::factory()->create();
    $salaryPayment = SalaryPayment::factory()->create(['employee_id' => $employee->id]);
    $this->actingAs($admin);
    $updateData = [
        'employee_id' => $employee->id,
        'amount' => 999,
        'date' => now()->toDateString(),
        'note' => 'Updated',
    ];
    $response = $this->put("/salary-payments/{$salaryPayment->id}", $updateData);
    $response->assertRedirect(route('salary-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('salary_payments', ['id' => $salaryPayment->id, 'amount' => 999]);
});

test('admin can delete a salary payment', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $salaryPayment = SalaryPayment::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/salary-payments/{$salaryPayment->id}");
    $response->assertRedirect(route('salary-payments.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('salary_payments', ['id' => $salaryPayment->id]);
});

test('employee cannot access salary payment CRUD', function () {
    $employeeUser = User::factory()->create(['role' => 'employee', 'status' => 'active']);
    $salaryPayment = SalaryPayment::factory()->create();
    $this->actingAs($employeeUser);
    $response = $this->get('/salary-payments');
    $response->assertForbidden();
    $response = $this->post('/salary-payments', [
        'employee_id' => $salaryPayment->employee_id,
        'amount' => 100,
        'date' => now()->toDateString(),
    ]);
    $response->assertForbidden();
    $response = $this->put("/salary-payments/{$salaryPayment->id}", ['amount' => 100]);
    $response->assertForbidden();
    $response = $this->delete("/salary-payments/{$salaryPayment->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access salary payment CRUD', function () {
    $salaryPayment = SalaryPayment::factory()->create();
    $response = $this->get('/salary-payments');
    $response->assertRedirect('/login');
    $response = $this->post('/salary-payments', [
        'employee_id' => $salaryPayment->employee_id,
        'amount' => 100,
        'date' => now()->toDateString(),
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/salary-payments/{$salaryPayment->id}", ['amount' => 100]);
    $response->assertRedirect('/login');
    $response = $this->delete("/salary-payments/{$salaryPayment->id}");
    $response->assertRedirect('/login');
}); 