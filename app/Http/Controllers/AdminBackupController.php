<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\User;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\Distributor;
use App\Models\DistributorPayment;
use App\Models\DistributorProduct;
use App\Models\Shopkeeper;
use App\Models\ShopkeeperTransaction;
use App\Models\ReturnTransaction;
use App\Models\Employee;
use App\Models\SalaryPayment;
use App\Models\Expense;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminBackupController extends Controller
{
    private function exportWithHeaders($collection, $headers, $mapFn, $filePath)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($headers, null, 'A1');
        $rows = $collection->map($mapFn)->all();
        $sheet->fromArray($rows, null, 'A2');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public function exportAll(Request $request)
    {
        $categories = $request->input('categories', []);
        if (empty($categories)) {
            return redirect()->route('admin.csv-backup')->with('error', 'Please select at least one category to backup.');
        }

        $files = [];
        $tmpDir = storage_path('app/tmp_backup_' . uniqid());
        mkdir($tmpDir);

        foreach ($categories as $cat) {
            switch ($cat) {
                case 'users':
                    $headers = ['Name', 'Email', 'Role', 'Status', 'Created At'];
                    $users = User::all();
                    $this->exportWithHeaders($users, $headers, function($u) {
                        return [
                            $u->name,
                            $u->email,
                            $u->role,
                            $u->status ?? '',
                            $u->created_at ? $u->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/users.xlsx');
                    $files[] = $tmpDir . '/users.xlsx';
                    break;
                case 'suppliers':
                    $headers = ['Supplier Name', 'Contact Person', 'Phone', 'Email', 'Country', 'Company', 'Created At'];
                    $suppliers = Supplier::with('company')->get();
                    $this->exportWithHeaders($suppliers, $headers, function($s) {
                        return [
                            $s->supplier_name,
                            $s->contact_person,
                            $s->cell_no,
                            $s->email,
                            $s->country,
                            $s->company->name ?? '',
                            $s->created_at ? $s->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/suppliers.xlsx');
                    $files[] = $tmpDir . '/suppliers.xlsx';
                    // Payments
                    $headers2 = ['Supplier Name', 'Amount', 'Type', 'Date', 'Status'];
                    $payments = SupplierPayment::with('supplier')->get();
                    $this->exportWithHeaders($payments, $headers2, function($p) {
                        return [
                            $p->supplier->supplier_name ?? '',
                            $p->amount,
                            $p->type,
                            $p->payment_date,
                            $p->status,
                        ];
                    }, $tmpDir . '/supplier_payments.xlsx');
                    $files[] = $tmpDir . '/supplier_payments.xlsx';
                    break;
                case 'shopkeepers':
                    $headers = ['Name', 'Phone', 'Address', 'Created At'];
                    $shopkeepers = Shopkeeper::all();
                    $this->exportWithHeaders($shopkeepers, $headers, function($s) {
                        return [
                            $s->name,
                            $s->phone,
                            $s->address,
                            $s->created_at ? $s->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/shopkeepers.xlsx');
                    $files[] = $tmpDir . '/shopkeepers.xlsx';
                    // Transactions
                    $headers2 = ['Shopkeeper Name', 'Amount', 'Type', 'Date', 'Status'];
                    $transactions = ShopkeeperTransaction::with('shopkeeper')->get();
                    $this->exportWithHeaders($transactions, $headers2, function($t) {
                        return [
                            $t->shopkeeper->name ?? '',
                            $t->amount,
                            $t->type,
                            $t->date,
                            $t->status,
                        ];
                    }, $tmpDir . '/shopkeeper_transactions.xlsx');
                    $files[] = $tmpDir . '/shopkeeper_transactions.xlsx';
                    break;
                case 'distributors':
                    $headers = ['Distributor Name', 'Contact', 'Phone', 'Company', 'Created At'];
                    $distributors = Distributor::with('company')->get();
                    $this->exportWithHeaders($distributors, $headers, function($d) {
                        return [
                            $d->name,
                            $d->contact_person,
                            $d->phone,
                            $d->company->name ?? '',
                            $d->created_at ? $d->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/distributors.xlsx');
                    $files[] = $tmpDir . '/distributors.xlsx';
                    // Payments
                    $headers2 = ['Distributor Name', 'Amount', 'Type', 'Date', 'Status'];
                    $payments = DistributorPayment::with('distributor')->get();
                    $this->exportWithHeaders($payments, $headers2, function($p) {
                        return [
                            $p->distributor->name ?? '',
                            $p->amount,
                            $p->type,
                            $p->payment_date,
                            $p->status,
                        ];
                    }, $tmpDir . '/distributor_payments.xlsx');
                    $files[] = $tmpDir . '/distributor_payments.xlsx';
                    // Products
                    $headers3 = ['Distributor Name', 'Product', 'Assignment Number', 'Created At'];
                    $products = DistributorProduct::with('distributor')->get();
                    $this->exportWithHeaders($products, $headers3, function($p) {
                        return [
                            $p->distributor->name ?? '',
                            $p->product_name ?? '',
                            $p->assignment_number,
                            $p->created_at ? $p->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/distributor_products.xlsx');
                    $files[] = $tmpDir . '/distributor_products.xlsx';
                    break;
                case 'returns':
                    $headers = ['Sale Code', 'Customer', 'Item', 'Qty', 'Amount', 'Reason', 'Processed By', 'Date'];
                    $returns = ReturnTransaction::with('sale.customer', 'item')->get();
                    $this->exportWithHeaders($returns, $headers, function($r) {
                        return [
                            $r->sale->sale_code ?? '',
                            $r->sale->customer->name ?? '',
                            $r->item->item_name ?? '',
                            $r->quantity,
                            $r->amount,
                            $r->reason,
                            $r->processed_by,
                            $r->created_at ? $r->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/returns.xlsx');
                    $files[] = $tmpDir . '/returns.xlsx';
                    break;
                case 'hr':
                    $headers = ['Name', 'Position', 'Salary', 'Contact', 'Created At'];
                    $employees = Employee::all();
                    $this->exportWithHeaders($employees, $headers, function($e) {
                        return [
                            $e->name,
                            $e->position,
                            $e->salary,
                            $e->contact,
                            $e->created_at ? $e->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/employees.xlsx');
                    $files[] = $tmpDir . '/employees.xlsx';
                    // Salaries
                    $headers2 = ['Employee Name', 'Amount', 'Payment Date', 'Status'];
                    $salaries = SalaryPayment::with('employee')->get();
                    $this->exportWithHeaders($salaries, $headers2, function($s) {
                        return [
                            $s->employee->name ?? '',
                            $s->amount,
                            $s->payment_date,
                            $s->status,
                        ];
                    }, $tmpDir . '/salary_payments.xlsx');
                    $files[] = $tmpDir . '/salary_payments.xlsx';
                    break;
                case 'reports':
                    // Sales
                    $headers = ['Sale Code', 'Customer', 'Amount', 'Type', 'Date', 'Status'];
                    $sales = Sale::with('customer')->get();
                    $this->exportWithHeaders($sales, $headers, function($s) {
                        return [
                            $s->sale_code,
                            $s->customer->name ?? '',
                            $s->amount,
                            $s->type,
                            $s->created_at ? $s->created_at->format('Y-m-d') : '',
                            $s->status ?? '',
                        ];
                    }, $tmpDir . '/sales.xlsx');
                    $files[] = $tmpDir . '/sales.xlsx';
                    // Purchases
                    $headers2 = ['Item Name', 'Qty', 'Unit Price', 'Total', 'Date'];
                    $purchases = Inventory::all();
                    $this->exportWithHeaders($purchases, $headers2, function($p) {
                        return [
                            $p->item_name ?? '',
                            $p->quantity ?? '',
                            $p->unit_price ?? '',
                            $p->total ?? '',
                            $p->created_at ? $p->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/inventory.xlsx');
                    $files[] = $tmpDir . '/inventory.xlsx';
                    // Expenses
                    $headers3 = ['Purpose', 'Details', 'Amount', 'Paid By', 'Payment Way', 'Date'];
                    $expenses = Expense::all();
                    $this->exportWithHeaders($expenses, $headers3, function($e) {
                        return [
                            $e->purpose,
                            $e->details,
                            $e->amount,
                            $e->paidBy,
                            $e->paymentWay,
                            $e->created_at ? $e->created_at->format('Y-m-d') : '',
                        ];
                    }, $tmpDir . '/expenses.xlsx');
                    $files[] = $tmpDir . '/expenses.xlsx';
                    break;
            }
        }

        // Create ZIP
        $zipPath = storage_path('app/backup_' . date('Ymd_His') . '.zip');
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();

        // Clean up temp files
        foreach ($files as $file) {
            @unlink($file);
        }
        @rmdir($tmpDir);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function fullBackup(Request $request)
    {
        $backupDir = storage_path('full_backup_' . uniqid());
        mkdir($backupDir);
        // 1. Database dump
        $db = config('database.connections.mysql');
        $dbFile = $backupDir . '/database_backup.sql';
        $cmd = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($dbFile)
        );
        $result = null;
        @exec($cmd, $output, $result);
        // 2. Copy storage files, but skip the backupDir itself to avoid recursion
        $storageSource = storage_path('app');
        $storageDest = $backupDir . '/files';
        $this->recurseCopy($storageSource, $storageDest);
        // 3. Zip everything
        $zipPath = storage_path('app/full_backup_' . date('Ymd_His') . '.zip');
        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($backupDir));
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relPath = substr($filePath, strlen($backupDir) + 1);
                $zip->addFile($filePath, $relPath);
            }
        }
        $zip->close();
        // Clean up temp dir
        $this->recurseDelete($backupDir);
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    // Modified recurseCopy to accept an array of paths to skip
    private function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;
                // Skip any directory named full_backup_*
                if (is_dir($srcPath) && strpos($file, 'full_backup_') === 0) {
                    continue;
                }
                if (is_dir($srcPath)) {
                    $this->recurseCopy($srcPath, $dstPath);
                } else {
                    copy($srcPath, $dstPath);
                }
            }
        }
        closedir($dir);
    }
    private function recurseDelete($dir)
    {
        if (!file_exists($dir)) return;
        foreach (scandir($dir) as $file) {
            if ($file == '.' || $file == '..') continue;
            $full = $dir . '/' . $file;
            if (is_dir($full)) $this->recurseDelete($full);
            else @unlink($full);
        }
        @rmdir($dir);
    }

    // Show the backup/restore UI page
    public function showPage(Request $request)
    {
        $cloudBackup = null;
        if (auth()->check()) {
            $cloudBackup = \App\Models\CloudBackup::where('user_id', auth()->id())->where('provider', 'google')->first();
        }
        return view('admin.csv_backup', compact('cloudBackup'));
    }

    // Remove import/restore and CSV logic. Only keep exportAll, showPage, and exportWithHeaders.
} 