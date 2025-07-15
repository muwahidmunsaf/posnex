<?php

use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('admin can access activity logs', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/activity-logs');
    $response->assertStatus(200);
    $response->assertSee('Activity Log');
});

test('unauthenticated user is redirected from activity logs', function () {
    $response = $this->get('/activity-logs');
    $response->assertRedirect('/login');
});

test('employee cannot access activity logs', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $this->actingAs($employee);
    $response = $this->get('/activity-logs');
    $response->assertForbidden();
});

test('activity logs can be filtered by user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    // Create some activity logs
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Supplier',
        'details' => 'Supplier: Test Supplier',
    ]);
    
    $response = $this->get('/activity-logs?user=' . $admin->name);
    $response->assertStatus(200);
    $response->assertSee($admin->name);
});

test('activity logs can be filtered by role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Supplier',
        'details' => 'Supplier: Test Supplier',
    ]);
    
    $response = $this->get('/activity-logs?role=admin');
    $response->assertStatus(200);
    $response->assertSee('admin');
});

test('activity logs can be filtered by action', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Supplier',
        'details' => 'Supplier: Test Supplier',
    ]);
    
    $response = $this->get('/activity-logs?action=Created');
    $response->assertStatus(200);
    $response->assertSee('Created Supplier');
});

test('activity logs can be filtered by date', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Supplier',
        'details' => 'Supplier: Test Supplier',
    ]);
    
    $today = now()->format('Y-m-d');
    $response = $this->get('/activity-logs?date=' . $today);
    $response->assertStatus(200);
});

test('supplier creation logs activity', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    
    $supplierData = Supplier::factory()->make(['company_id' => $company->id])->toArray();
    unset($supplierData['company_id']);
    
    $this->post('/suppliers', $supplierData);
    
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Supplier',
    ]);
});

test('sale creation logs activity', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    
    // Create inventory item for the sale
    $inventory = Inventory::factory()->create([
        'company_id' => $company->id,
        'unit' => 10,
        'status' => 'active'
    ]);
    
    // Create customer for the sale
    $customer = Customer::factory()->create([
        'company_id' => $company->id,
        'type' => 'wholesale'
    ]);
    
    $saleData = [
        'sale_type' => 'wholesale',
        'wholesale_customer_id' => $customer->id,
        'items' => [
            [
                'inventory_id' => $inventory->id,
                'quantity' => 2
            ]
        ],
        'payment_method' => 'cash',
        'discount' => 0,
        'amount_received' => 100,
        'change_return' => 0
    ];
    
    $token = 'test-sale-token-activitylog';
    session(['sale_idempotency_token' => $token]);
    $saleData['idempotency_token'] = $token;
    $this->post('/sales', $saleData);
    
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Sale',
    ]);
});

test('employee creation logs activity', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    
    $employeeData = Employee::factory()->make(['company_id' => $company->id])->toArray();
    
    $this->post('/employees', $employeeData);
    
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Employee',
    ]);
});

test('payment creation logs activity', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    
    // Create customer for the payment
    $customer = Customer::factory()->create([
        'company_id' => $company->id,
        'type' => 'wholesale'
    ]);
    
    $paymentData = [
        'customer_id' => $customer->id,
        'amount_paid' => 100,
        'amount_due' => 0,
        'note' => 'Test payment'
    ];
    
    $this->post('/payments/store', $paymentData);
    
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Payment',
    ]);
});

test('activity logs show comprehensive details', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Created Supplier',
        'details' => 'Supplier: Test Supplier, Amount: 1000',
    ]);
    
    $response = $this->get('/activity-logs');
    $response->assertStatus(200);
    $response->assertSee('Test Supplier');
    $response->assertSee('1000');
});

test('activity logs are paginated', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    // Create more than 20 logs (default pagination)
    for ($i = 0; $i < 25; $i++) {
        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => $admin->name,
            'user_role' => $admin->role,
            'action' => 'Test Action ' . $i,
            'details' => 'Test Details ' . $i,
        ]);
    }
    
    $response = $this->get('/activity-logs');
    $response->assertStatus(200);
    // Should show pagination elements (Bootstrap 5 template)
    $response->assertSee('Showing');
    $response->assertSee('results');
    $response->assertSee('Next');
});

test('activity logs are ordered by latest first', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    // Create first log
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'First Action',
        'details' => 'First Details',
    ]);
    
    // Small delay to ensure different timestamps
    sleep(1);
    
    // Create second log
    ActivityLog::create([
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
        'action' => 'Second Action',
        'details' => 'Second Details',
    ]);
    
    $response = $this->get('/activity-logs');
    $response->assertStatus(200);
    // Second action should appear first (latest first)
    $response->assertSeeInOrder(['Second Action', 'First Action']);
});

test('activity logs capture all major CRUD operations', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    
    // Test Create
    $supplierData = Supplier::factory()->make(['company_id' => $company->id])->toArray();
    unset($supplierData['company_id']);
    $this->post('/suppliers', $supplierData);
    
    // Test Update
    $supplier = Supplier::where('supplier_name', $supplierData['supplier_name'])->first();
    $this->put("/suppliers/{$supplier->id}", [
        'supplier_name' => 'Updated Supplier',
        'cell_no' => '03001234567',
        'contact_person' => 'Updated Person',
        'country' => 'Updated Country',
        'company_id' => $company->id,
    ]);
    
    // Test Delete
    $this->delete("/suppliers/{$supplier->id}");
    
    // Verify all actions are logged
    $this->assertDatabaseHas('activity_logs', ['action' => 'Created Supplier']);
    $this->assertDatabaseHas('activity_logs', ['action' => 'Updated Supplier']);
    $this->assertDatabaseHas('activity_logs', ['action' => 'Deleted Supplier']);
});

test('activity logs include user context', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    
    $supplierData = Supplier::factory()->make(['company_id' => $company->id])->toArray();
    unset($supplierData['company_id']);
    $this->post('/suppliers', $supplierData);
    
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin->id,
        'user_name' => $admin->name,
        'user_role' => $admin->role,
    ]);
});

test('activity logs handle multiple users', function () {
    $company = Company::factory()->create();
    $admin1 = User::factory()->create(['role' => 'admin', 'company_id' => $company->id, 'name' => 'Admin 1']);
    $admin2 = User::factory()->create(['role' => 'admin', 'company_id' => $company->id, 'name' => 'Admin 2']);
    
    // Admin 1 creates supplier
    $this->actingAs($admin1);
    $supplierData = Supplier::factory()->make(['company_id' => $company->id])->toArray();
    unset($supplierData['company_id']);
    $this->post('/suppliers', $supplierData);
    
    // Admin 2 creates customer
    $this->actingAs($admin2);
    $customerData = Customer::factory()->make(['company_id' => $company->id])->toArray();
    unset($customerData['company_id']);
    $this->post('/customers', $customerData);
    
    // Verify both users' actions are logged
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin1->id,
        'user_name' => 'Admin 1',
        'action' => 'Created Supplier',
    ]);
    
    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $admin2->id,
        'user_name' => 'Admin 2',
        'action' => 'Created Customer',
    ]);
}); 