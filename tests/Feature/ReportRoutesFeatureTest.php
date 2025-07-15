<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

$reportRoutes = [
    '/reports/stock' => 'Stock',
    '/reports/finance' => 'Finance',
    '/reports/purchase' => 'Purchase',
    '/reports/external-sales' => 'External Sales',
    '/reports/external-purchases' => 'External Purchases',
    '/reports/invoices' => 'INVOICE REPORT',
];

test('admin can access all report routes', function () use ($reportRoutes) {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    foreach ($reportRoutes as $route => $expectedText) {
        $response = $this->get($route);
        $response->assertStatus(200);
        $response->assertSee($expectedText);
    }
});

test('unauthenticated user is redirected from all report routes', function () use ($reportRoutes) {
    foreach (array_keys($reportRoutes) as $route) {
        $response = $this->get($route);
        $response->assertRedirect('/login');
    }
}); 