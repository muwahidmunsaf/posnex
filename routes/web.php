<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExternalSaleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\ProfileController;




Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');



// Company Pages

Route::middleware('auth')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
});

// User Management Pages

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
});

// Category Pages

Route::middleware(['auth'])->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Supplier Pages

Route::middleware(['auth'])->group(function () {
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::patch('/inventory/{inventory}/toggle-status', [InventoryController::class, 'toggleStatus'])->name('inventory.toggleStatus');
    Route::get('/inventory-status', [InventoryController::class, 'status'])->name('inventory.status');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{purchase}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/history/{customer}', [App\Http\Controllers\CustomerController::class, 'history'])->name('customers.history');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/invoices', [SaleController::class, 'view'])->name('sales.invoices');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/print/{id}', [SaleController::class, 'print'])->name('sales.print');
    Route::get('/sales/return/{sale}', [App\Http\Controllers\SaleController::class, 'returnForm'])->name('sales.return');
    Route::post('/sales/return/{sale}', [App\Http\Controllers\SaleController::class, 'processReturn'])->name('sales.processReturn');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/external-sales', [ExternalSaleController::class, 'index'])->name('external-sales.index');
    Route::get('/external-sales/create', [ExternalSaleController::class, 'create'])->name('external-sales.create');
    Route::post('/external-sales', [ExternalSaleController::class, 'store'])->name('external-sales.store');
    Route::get('external-sales/{id}/invoice', [ExternalSaleController::class, 'invoice'])->name('external-sales.invoice');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reports/invoices', [ReportController::class, 'invoices'])->name('reports.invoices');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/external-sales', [ReportController::class, 'externalSales'])->name('reports.externalSales');
    Route::get('/reports/external-purchases', [ReportController::class, 'externalPurchases'])->name('reports.externalPurchases');
    Route::get('/reports/finance', [ReportController::class, 'financeReport'])->name('reports.finance');
    Route::get('/reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
    Route::get('/reports/daily-sales', [App\Http\Controllers\ReportController::class, 'dailySales'])->name('reports.dailySales');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/company/settings', [CompanySettingsController::class, 'edit'])->name('company.settings.edit');
    Route::post('/company/settings', [CompanySettingsController::class, 'update'])->name('company.settings.update');
});

Route::post('/payments/store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');

Route::middleware(['auth'])->group(function () {
    // Custom employee salary payment routes FIRST
    Route::get('employees/pay-salaries', [App\Http\Controllers\EmployeeController::class, 'paySalariesForm'])->name('employees.paySalaries');
    Route::post('employees/pay-salaries', [App\Http\Controllers\EmployeeController::class, 'paySalariesProcess'])->name('employees.paySalaries.process');
    // Then the resource route
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    Route::resource('salaries', App\Http\Controllers\SalaryController::class);
    Route::get('salaries/bulk', [App\Http\Controllers\SalaryController::class, 'bulkForm'])->name('salaries.bulk');
    Route::post('salaries/bulk-pay', [App\Http\Controllers\SalaryController::class, 'bulkPay'])->name('salaries.bulkPay');
    Route::get('activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/returns', [App\Http\Controllers\ReturnTransactionController::class, 'index'])->name('returns.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/backups', [App\Http\Controllers\BackupController::class, 'listBackups'])->name('admin.backups');
    Route::post('/admin/backup', [App\Http\Controllers\BackupController::class, 'runBackup'])->name('admin.backup');
    Route::post('/admin/restore', [App\Http\Controllers\BackupController::class, 'runRestore'])->name('admin.restore');
    Route::get('/admin/backup/download/{file}', [App\Http\Controllers\BackupController::class, 'downloadBackup'])->name('admin.backup.download');
});

