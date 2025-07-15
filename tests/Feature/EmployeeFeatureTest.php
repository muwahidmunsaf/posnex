<?php

use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create an employee', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $data = \App\Models\Employee::factory()->make(['company_id' => $company->id])->toArray();
    unset($data['email']);
    $response = $this->post('/employees', $data);
    $response->assertRedirect();
    $this->assertDatabaseHas('employees', ['name' => $data['name'], 'company_id' => $company->id]);
});

test('employee creation fails with invalid data', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->post('/employees', [
        'name' => '',
        'position' => '',
        'salary' => null,
        'company_id' => $company->id,
    ]);
    $response->assertSessionHasErrors(['name', 'position', 'salary']);
});

test('admin can update an employee', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $employee = \App\Models\Employee::factory()->create(['company_id' => $company->id]);
    $updateData = [
        'name' => 'Updated Name',
        'position' => $employee->position,
        'salary' => $employee->salary,
        'contact' => $employee->contact,
        'address' => $employee->address,
        'company_id' => $company->id,
    ];
    $response = $this->put("/employees/{$employee->id}", $updateData);
    $response->assertRedirect();
    $this->assertDatabaseHas('employees', ['id' => $employee->id, 'name' => 'Updated Name']);
});

test('admin can delete an employee', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $employee = \App\Models\Employee::factory()->create(['company_id' => $company->id]);
    $response = $this->delete("/employees/{$employee->id}");
    $response->assertRedirect();
    $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
}); 