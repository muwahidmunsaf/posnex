<?php

use App\Models\User;
use App\Models\Company;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Simulate navigation from dashboard to sales, then back to dashboard
// (Note: Laravel feature tests cannot simulate browser history, but can simulate sequential requests)
test('user can navigate from dashboard to sales and back', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $dashboard = $this->get(route('dashboard'));
    $dashboard->assertStatus(200)->assertSee('dashboard');
    $sales = $this->get(route('sales.index'));
    $sales->assertStatus(200)->assertSee('Sale');
    // Simulate 'back' by re-requesting dashboard
    $dashboardAgain = $this->get(route('dashboard'));
    $dashboardAgain->assertStatus(200)->assertSee('dashboard');
});

// After submitting a sale, using back/refresh does not duplicate or resubmit data
test('after submitting sale, back/refresh does not duplicate sale', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id, 'unit' => 10, 'status' => 'active']);
    $saleData = Sale::factory()->make([
        'company_id' => $company->id,
        'sale_type' => 'retail',
        'payment_method' => 'cash',
    ])->toArray();
    $saleData['items'] = [
        [
            'inventory_id' => $inventory->id,
            'quantity' => 1,
        ]
    ];
    $saleData['retail_customer_name'] = 'Test Customer';
    // Simulate sale submission with idempotency token
    $token = 'test-sale-token-123';
    session(['sale_idempotency_token' => $token]);
    $saleData['idempotency_token'] = $token;
    $response = $this->post(route('sales.store'), $saleData);
    $response->assertStatus(200)->assertSee('Sale Receipt'); // Match actual view
    $this->assertDatabaseHas('sales', ['company_id' => $company->id, 'sale_type' => $saleData['sale_type']]);
    // Simulate back/refresh by re-posting same data (token already consumed)
    $saleData['idempotency_token'] = $token;
    $response2 = $this->post(route('sales.store'), $saleData);
    // Should not create duplicate (should redirect or show error)
    $salesCount = Sale::where('company_id', $company->id)->where('sale_type', $saleData['sale_type'])->count();
    expect($salesCount)->toBe(1);
});

// Session and navigation state for purchases
test('purchase form submission and navigation does not duplicate purchase', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $supplier = \App\Models\Supplier::factory()->create(['company_id' => $company->id]);
    $inventory = \App\Models\Inventory::factory()->create(['company_id' => $company->id]);
    $purchaseData = Purchase::factory()->make([
        'company_id' => $company->id,
        'supplier_id' => $supplier->id,
        'purchase_date' => now()->toDateString(),
    ])->toArray();
    $purchaseData['items'] = [
        [
            'inventory_id' => $inventory->id,
            'quantity' => 2,
            'purchase_amount' => 100,
        ]
    ];
    $token = 'test-purchase-token-123';
    session(['purchase_idempotency_token' => $token]);
    $purchaseData['idempotency_token'] = $token;
    $response = $this->post(route('purchase.store'), $purchaseData);
    $response->assertRedirect(route('purchase.print', 1));
    $this->assertDatabaseHas('purchases', ['company_id' => $company->id, 'total_amount' => 100]);
    // Simulate back/refresh by re-posting same data
    $purchaseData['idempotency_token'] = $token;
    $response2 = $this->post(route('purchase.store'), $purchaseData);
    $purchasesCount = Purchase::where('company_id', $company->id)->where('total_amount', 100)->count();
    expect($purchasesCount)->toBe(1);
});

// Reports navigation
test('user can navigate to reports and back', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $dashboard = $this->get(route('dashboard'));
    $dashboard->assertStatus(200);
    $reports = $this->get(route('reports.invoices'));
    $reports->assertStatus(200)->assertSee('INVOICE REPORT');
    $dashboardAgain = $this->get(route('dashboard'));
    $dashboardAgain->assertStatus(200);
}); 