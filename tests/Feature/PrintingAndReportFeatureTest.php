<?php

use App\Models\User;
use App\Models\Company;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Distributor;
use App\Models\DistributorProduct;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can print sale invoice', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $sale = Sale::factory()->create(['company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('sales.print', $sale->id));
    $response->assertStatus(200);
    $response->assertSee((string)$sale->sale_code);
});

test('admin can print purchase invoice', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $purchase = Purchase::factory()->create(['company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('purchase.print', $purchase->id));
    $response->assertStatus(200);
    $response->assertSee((string)$purchase->id);
});

test('admin can print customer history', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $customer = Customer::factory()->create(['company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('customers.printHistory', $customer->id));
    $response->assertStatus(200);
    $response->assertSee($customer->name);
});

test('admin can print all customers', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('customers.printAll'));
    $response->assertStatus(200);
    $response->assertSee('Customer');
});

test('admin can print supplier history', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $supplier = Supplier::factory()->create(['company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('suppliers.printHistory', $supplier->id));
    $response->assertStatus(200);
    $response->assertSee($supplier->supplier_name);
});

test('admin can print all suppliers', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('suppliers.printAll'));
    $response->assertStatus(200);
    $response->assertSee('Supplier');
});

test('admin can print supplier payment receipt', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $supplier = Supplier::factory()->create(['company_id' => $company->id]);
    $payment = \App\Models\SupplierPayment::factory()->create(['supplier_id' => $supplier->id]);
    $this->actingAs($admin);
    $response = $this->get(route('suppliers.printPaymentReceipt', [$supplier->id, $payment->id]));
    $response->assertStatus(200);
    $response->assertSee((string)$payment->id);
});

test('admin can print distributor product assignment receipt', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $distributor = Distributor::factory()->create(['company_id' => $company->id]);
    $product = DistributorProduct::factory()->create(['distributor_id' => $distributor->id]);
    $this->actingAs($admin);
    $response = $this->get(route('distributor-products.print-receipt', $product));
    $response->assertStatus(200);
    $response->assertSee((string)$product->assignment_number);
});

test('admin can print dashboard report', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('dashboard.print'));
    $response->assertStatus(200);
    $response->assertSee('Total Sales');
});

test('admin can print invoice report', function () {
    $company = Company::factory()->create();
    $admin = User::factory()->create(['role' => 'admin', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get(route('reports.invoices'));
    $response->assertStatus(200);
    $response->assertSee('INVOICE REPORT');
});

test('unauthenticated user cannot access print/report endpoints', function () {
    $sale = Sale::factory()->create();
    $purchase = Purchase::factory()->create();
    $customer = Customer::factory()->create();
    $supplier = Supplier::factory()->create();
    $response = $this->get(route('sales.print', $sale->id));
    $response->assertRedirect('/login');
    $response = $this->get(route('purchase.print', $purchase->id));
    $response->assertRedirect('/login');
    $response = $this->get(route('customers.printHistory', $customer->id));
    $response->assertRedirect('/login');
    $response = $this->get(route('suppliers.printHistory', $supplier->id));
    $response->assertRedirect('/login');
}); 