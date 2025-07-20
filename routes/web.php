<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
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
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ShopkeeperController;
use App\Http\Controllers\DistributorPaymentController;
use App\Http\Controllers\DistributorProductController;
use App\Http\Controllers\ShopkeeperTransactionController;
use App\Models\Supplier;
use App\Http\Controllers\AdminBackupController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/print', [App\Http\Controllers\DashboardController::class, 'print'])->name('dashboard.print');


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

// Supplier Pages

Route::middleware(['auth'])->group(function () {
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/print-all', [App\Http\Controllers\SupplierController::class, 'printAll'])->name('suppliers.printAll');
    // Move deleted route BEFORE the {supplier} route to avoid conflict
    Route::get('suppliers/deleted', [App\Http\Controllers\SupplierController::class, 'deletedSuppliers'])->name('suppliers.deleted');
    Route::post('suppliers/{id}/restore', [App\Http\Controllers\SupplierController::class, 'restore'])->name('suppliers.restore');
    // Now the {supplier} route comes after specific routes
    Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    Route::post('suppliers/{supplier}/pay', [App\Http\Controllers\SupplierController::class, 'pay'])->name('suppliers.pay');
    Route::delete('suppliers/{supplier}/payments/{payment}', [App\Http\Controllers\SupplierController::class, 'deletePayment'])->name('suppliers.deletePayment');
    Route::get('suppliers/{supplier}/payment-receipt/{payment}', [App\Http\Controllers\SupplierController::class, 'printPaymentReceipt'])->name('suppliers.printPaymentReceipt');
    Route::get('suppliers/{supplier}/print-history', [App\Http\Controllers\SupplierController::class, 'printHistory'])->name('suppliers.printHistory');
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
    Route::post('/inventory/bulk-delete', [InventoryController::class, 'bulkDelete'])->name('inventory.bulkDelete');
    Route::post('/inventory/import-excel', [InventoryController::class, 'importExcel'])->name('inventory.importExcel');
    Route::get('/inventory/export-excel', [InventoryController::class, 'exportExcel'])->name('inventory.exportExcel');
    Route::get('/inventory/print-catalogue', [InventoryController::class, 'printCatalogue'])->name('inventory.printCatalogue');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{purchase}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    Route::get('/purchase/print/{id}', [PurchaseController::class, 'print'])->name('purchase.print');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/history/{customer}', [App\Http\Controllers\CustomerController::class, 'history'])->name('customers.history');
    Route::get('/customers/print-all', [App\Http\Controllers\CustomerController::class, 'printAll'])->name('customers.printAll');
    Route::get('/customers/print-history/{id}', [App\Http\Controllers\CustomerController::class, 'printHistory'])->name('customers.printHistory');
    Route::get('/customers/deleted', [App\Http\Controllers\CustomerController::class, 'deletedCustomers'])->name('customers.deleted');
    Route::post('/customers/{id}/restore', [App\Http\Controllers\CustomerController::class, 'restore'])->name('customers.restore');
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

Route::resource('sales', SaleController::class)->except(['show']);

Route::middleware(['auth'])->group(function () {
    Route::get('/external-sales', [ExternalSaleController::class, 'index'])->name('external-sales.index');
    Route::get('/external-sales/create', [ExternalSaleController::class, 'create'])->name('external-sales.create');
    Route::post('/external-sales', [ExternalSaleController::class, 'store'])->name('external-sales.store');
    Route::get('external-sales/{id}/invoice', [ExternalSaleController::class, 'invoice'])->name('external-sales.invoice');
    Route::get('external-sales/{id}/edit', [ExternalSaleController::class, 'edit'])->name('external-sales.edit');
    Route::put('external-sales/{id}', [ExternalSaleController::class, 'update'])->name('external-sales.update');
    Route::delete('external-sales/{id}', [ExternalSaleController::class, 'destroy'])->name('external-sales.destroy');
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

Route::middleware(['auth'])->group(function () {
    Route::get('/recycle-bin', [App\Http\Controllers\ReportController::class, 'recycleBin'])->name('recycle.bin');
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
Route::delete('/payments/{id}', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.destroy');
Route::get('/payments/{id}/print', [App\Http\Controllers\PaymentController::class, 'print'])->name('payments.print');
Route::put('/payments/{id}', [App\Http\Controllers\PaymentController::class, 'update'])->name('payments.update');

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
    Route::post('/returns', [App\Http\Controllers\ReturnTransactionController::class, 'store'])->name('returns.store');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/backups', [App\Http\Controllers\BackupController::class, 'listBackups'])->name('admin.backups');
//     Route::post('/admin/backup', [App\Http\Controllers\BackupController::class, 'runBackup'])->name('admin.backup');
//     Route::post('/admin/restore', [App\Http\Controllers\BackupController::class, 'runRestore'])->name('admin.restore');
//     Route::get('/admin/backup/download/{file}', [App\Http\Controllers\BackupController::class, 'downloadBackup'])->name('admin.backup.download');
// });

// Route::resource('distributors', DistributorController::class); // Disabled to prevent access to distributor detail page
Route::middleware(['auth'])->group(function () {
    Route::get('distributors', [App\Http\Controllers\DistributorController::class, 'index'])->name('distributors.index');
    Route::get('distributors/create', [App\Http\Controllers\DistributorController::class, 'create'])->name('distributors.create');
    Route::post('distributors', [App\Http\Controllers\DistributorController::class, 'store'])->name('distributors.store');
    Route::get('distributors/print-all', [App\Http\Controllers\DistributorController::class, 'printAll'])->name('distributors.printAll');
    Route::get('distributors/{distributor}/edit', [App\Http\Controllers\DistributorController::class, 'edit'])->name('distributors.edit');
    Route::put('distributors/{distributor}', [\App\Http\Controllers\DistributorController::class, 'update'])->name('distributors.update');
    Route::get('distributors/{distributor}/history', [DistributorController::class, 'history'])->name('distributors.history');
    Route::get('distributors/{distributor}/print-history', [App\Http\Controllers\DistributorController::class, 'printHistory'])->name('distributors.printHistory');
    Route::get('distributors/{distributor}', [App\Http\Controllers\DistributorController::class, 'show'])->name('distributors.show');
    Route::delete('distributors/{distributor}', [App\Http\Controllers\DistributorController::class, 'destroy'])->name('distributors.destroy');
    Route::get('/distributors/deleted', [App\Http\Controllers\DistributorController::class, 'deletedDistributors'])->name('distributors.deleted');
    Route::post('/distributors/{id}/restore', [App\Http\Controllers\DistributorController::class, 'restore'])->name('distributors.restore');
});
Route::middleware(['auth'])->group(function () {
    Route::get('shopkeepers/print-all', [App\Http\Controllers\ShopkeeperController::class, 'printAll'])->name('shopkeepers.printAll');
    Route::resource('shopkeepers', ShopkeeperController::class);
    Route::get('shopkeepers/{shopkeeper}/print-history', [ShopkeeperController::class, 'printHistory'])->name('shopkeepers.printHistory');
    Route::get('/shopkeepers/deleted', [App\Http\Controllers\ShopkeeperController::class, 'deletedShopkeepers'])->name('shopkeepers.deleted');
    Route::post('/shopkeepers/{id}/restore', [App\Http\Controllers\ShopkeeperController::class, 'restore'])->name('shopkeepers.restore');
});
// Route::resource('distributor-payments', DistributorPaymentController::class); // Disabled old distributor payments system

// Define the route binding BEFORE the routes that use it

Route::post('/distributors/{distributor}/pay-commission', [App\Http\Controllers\DistributorPaymentController::class, 'store'])->name('distributors.payCommission');
Route::delete('distributors/{distributor}/commission/{distributorPayment}', [App\Http\Controllers\DistributorPaymentController::class, 'destroy'])->name('distributors.deleteCommission');
Route::post('/distributors/{distributor}/commission/{distributorPayment}/update', [App\Http\Controllers\DistributorPaymentController::class, 'update'])->name('distributors.updateCommission');

Route::middleware(['auth'])->group(function () {
    Route::post('shopkeeper-transactions', [App\Http\Controllers\ShopkeeperTransactionController::class, 'store'])->name('shopkeeper-transactions.store');
});

// Add missing resource and print/report routes for test coverage
Route::middleware(['auth'])->group(function () {
    // Route::resource('distributor-payments', App\Http\Controllers\DistributorPaymentController::class);
    Route::resource('distributor-products', App\Http\Controllers\DistributorProductController::class);
    Route::get('distributor-products/{distributor_product}/print-receipt', [App\Http\Controllers\DistributorProductController::class, 'printReceipt'])->name('distributor-products.print-receipt');
    Route::resource('purchase-items', App\Http\Controllers\PurchaseItemController::class);
    Route::resource('salary-payments', App\Http\Controllers\SalaryPaymentController::class);
    Route::resource('shopkeeper-transactions', App\Http\Controllers\ShopkeeperTransactionController::class);
    Route::resource('supplier-payments', App\Http\Controllers\SupplierPaymentController::class);
    Route::resource('inventory-sales', App\Http\Controllers\InventorySaleController::class);
    Route::resource('external-purchases', App\Http\Controllers\ExternalPurchaseController::class);
});

Route::get('/api/exchange-rate/{currency}', function($currency) {
    $rate = Supplier::getCurrencyRateToPKR($currency);
    return response()->json(['rate' => $rate]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/manage-backup', [App\Http\Controllers\AdminBackupController::class, 'showPage'])->name('admin.csv-backup');
    Route::post('/manage-backup', [App\Http\Controllers\AdminBackupController::class, 'exportAll'])->name('admin.csv-backup.export');
    Route::post('/manage-backup/restore', [App\Http\Controllers\AdminBackupController::class, 'import'])->name('admin.csv-restore');
    Route::post('/manage-backup/full-backup', [App\Http\Controllers\AdminBackupController::class, 'fullBackup'])->name('admin.full-backup');
});

// Cloud backup (Google Drive) routes
Route::middleware(['auth'])->group(function () {
    Route::get('/manage-backup/cloud-settings', [\App\Http\Controllers\CloudBackupController::class, 'settings'])->name('cloud-backup.settings');
    Route::post('/manage-backup/cloud-settings', [\App\Http\Controllers\CloudBackupController::class, 'updateSettings'])->name('cloud-backup.settings.update');
    Route::get('/manage-backup/google/redirect', [\App\Http\Controllers\CloudBackupController::class, 'redirectToGoogle'])->name('cloud-backup.google.redirect');
    Route::get('/manage-backup/google/callback', [\App\Http\Controllers\CloudBackupController::class, 'handleGoogleCallback'])->name('cloud-backup.google.callback');
});

// Reset Data (Admin Only)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/reset-data', [App\Http\Controllers\AdminResetController::class, 'showResetForm'])->name('admin.reset-data');
    Route::post('/admin/reset-data', [App\Http\Controllers\AdminResetController::class, 'resetData'])->name('admin.reset-data.post');
});

