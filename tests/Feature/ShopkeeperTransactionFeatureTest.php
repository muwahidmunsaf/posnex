<?php

use App\Models\User;
use App\Models\Distributor;
use App\Models\Shopkeeper;
use App\Models\ShopkeeperTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a shopkeeper transaction', function () {
    $distributor = Distributor::factory()->create();
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = ShopkeeperTransaction::factory()->make(['shopkeeper_id' => $shopkeeper->id, 'distributor_id' => $distributor->id])->toArray();
    $response = $this->post('/shopkeeper-transactions', $data);
    $response->assertRedirect(route('shopkeeper-transactions.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('shopkeeper_transactions', ['shopkeeper_id' => $shopkeeper->id, 'type' => $data['type']]);
});

test('shopkeeper transaction creation fails with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->post('/shopkeeper-transactions', [
        'shopkeeper_id' => null,
        'type' => '',
        'total_amount' => null,
    ]);
    $response->assertSessionHasErrors(['shopkeeper_id', 'type', 'total_amount']);
});

test('admin can update a shopkeeper transaction', function () {
    $distributor = Distributor::factory()->create();
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $transaction = ShopkeeperTransaction::factory()->create(['shopkeeper_id' => $shopkeeper->id, 'distributor_id' => $distributor->id]);
    $this->actingAs($admin);
    $updateData = [
        'shopkeeper_id' => $shopkeeper->id,
        'distributor_id' => $distributor->id,
        'type' => 'payment_made',
        'total_amount' => 999,
        'description' => 'Updated',
        'transaction_date' => now()->toDateString(),
    ];
    $response = $this->put("/shopkeeper-transactions/{$transaction->id}", $updateData);
    $response->assertRedirect(route('shopkeeper-transactions.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('shopkeeper_transactions', ['id' => $transaction->id, 'type' => 'payment_made', 'total_amount' => 999]);
});

test('admin can delete a shopkeeper transaction', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $transaction = ShopkeeperTransaction::factory()->create();
    $this->actingAs($admin);
    $response = $this->delete("/shopkeeper-transactions/{$transaction->id}");
    $response->assertRedirect(route('shopkeeper-transactions.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('shopkeeper_transactions', ['id' => $transaction->id]);
});

test('cannot delete shopkeeper with transactions', function () {
    $distributor = Distributor::factory()->create();
    $shopkeeper = Shopkeeper::factory()->create(['distributor_id' => $distributor->id]);
    $transaction = ShopkeeperTransaction::factory()->create(['shopkeeper_id' => $shopkeeper->id, 'distributor_id' => $distributor->id]);
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $response = $this->delete("/shopkeepers/{$shopkeeper->id}");
    // Should either fail or cascade delete depending on business logic
    $this->assertDatabaseHas('shopkeeper_transactions', ['id' => $transaction->id]);
});

test('employee cannot access shopkeeper transaction CRUD', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $transaction = ShopkeeperTransaction::factory()->create();
    $this->actingAs($employee);
    $response = $this->get('/shopkeeper-transactions');
    $response->assertForbidden();
    $response = $this->post('/shopkeeper-transactions', [
        'shopkeeper_id' => $transaction->shopkeeper_id,
        'type' => 'payment_made',
        'total_amount' => 100,
    ]);
    $response->assertForbidden();
    $response = $this->put("/shopkeeper-transactions/{$transaction->id}", ['total_amount' => 100]);
    $response->assertForbidden();
    $response = $this->delete("/shopkeeper-transactions/{$transaction->id}");
    $response->assertForbidden();
});

test('unauthenticated user cannot access shopkeeper transaction CRUD', function () {
    $transaction = ShopkeeperTransaction::factory()->create();
    $response = $this->get('/shopkeeper-transactions');
    $response->assertRedirect('/login');
    $response = $this->post('/shopkeeper-transactions', [
        'shopkeeper_id' => $transaction->shopkeeper_id,
        'type' => 'payment_made',
        'total_amount' => 100,
    ]);
    $response->assertRedirect('/login');
    $response = $this->put("/shopkeeper-transactions/{$transaction->id}", ['total_amount' => 100]);
    $response->assertRedirect('/login');
    $response = $this->delete("/shopkeeper-transactions/{$transaction->id}");
    $response->assertRedirect('/login');
}); 