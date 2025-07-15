<?php

use App\Models\User;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Distributor;
use App\Models\Shopkeeper;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can print all suppliers', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/suppliers/print-all');
    $response->assertStatus(200);
    $response->assertSee('Supplier');
});

test('admin can print all customers', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/customers/print-all');
    $response->assertStatus(200);
    $response->assertSee('Customer');
});

test('admin can print all distributors', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/distributors/print-all');
    $response->assertStatus(200);
    $response->assertSee('Distributor');
});

test('admin can print all shopkeepers', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->get('/shopkeepers/print-all');
    $response->assertStatus(200);
    $response->assertSee('Shopkeeper');
});

test('admin can print payment receipt', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $payment = Payment::factory()->create();
    $response = $this->get("/payments/{$payment->id}/print");
    $response->assertStatus(200);
    $response->assertSee('Receipt');
}); 