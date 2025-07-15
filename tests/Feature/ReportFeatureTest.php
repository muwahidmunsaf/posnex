<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can access daily sales report', function () {
    $company = \App\Models\Company::factory()->create();
    $admin = \App\Models\User::factory()->create(['role' => 'admin', 'status' => 'active', 'company_id' => $company->id]);
    $this->actingAs($admin);
    $response = $this->get('/reports/daily-sales');
    $response->assertStatus(200);
    $response->assertSee('Daily Sales');
});

test('unauthenticated user is redirected from reports', function () {
    $response = $this->get('/reports/daily-sales');
    $response->assertRedirect('/login');
}); 