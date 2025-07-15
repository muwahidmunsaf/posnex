<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can create a company', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $data = Company::factory()->make()->toArray();
    $response = $this->post('/companies', $data);
    $response->assertRedirect(route('companies.index'));
    $this->assertDatabaseHas('companies', ['name' => $data['name']]);
});

test('admin can update a company', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $company = Company::factory()->create();
    $updateData = array_merge($company->toArray(), ['name' => 'Updated Name']);
    $response = $this->put("/companies/{$company->id}", $updateData);
    $response->assertRedirect(route('companies.index'));
    $this->assertDatabaseHas('companies', ['id' => $company->id, 'name' => 'Updated Name']);
});

test('admin can delete a company', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $company = Company::factory()->create();
    $response = $this->delete("/companies/{$company->id}");
    $response->assertRedirect(route('companies.index'));
    $this->assertDatabaseMissing('companies', ['id' => $company->id]);
});

test('admin can update company settings', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    $company = Company::factory()->create();
    $settingsData = [
        'name' => 'New Company Name',
        'website' => 'https://example.com',
        // Add other settings fields as needed
    ];
    $response = $this->post('/company/settings', $settingsData);
    $response->assertRedirect();
    $this->assertDatabaseHas('companies', ['name' => 'New Company Name']);
}); 