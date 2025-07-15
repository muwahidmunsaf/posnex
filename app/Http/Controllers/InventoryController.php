<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Supplier;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InventoryController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Inventory::with(['supplier'])
            ->where('company_id', Auth::user()->company_id);

        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->input('per_page', 10);
        if ($perPage === 'all') {
            $inventories = $query->latest()->get();
        } else {
            $inventories = $query->latest()->paginate((int)$perPage)->appends($request->query());
        }

        return view('inventory.index', compact('inventories'));
    }

    public function status()
    {
        $inventories = Inventory::where('company_id', Auth::user()->company_id)->get();

        return view('inventory.status', compact('inventories'));
    }

    public function create()
    {
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();
        return view('inventory.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'retail_amount' => 'required|numeric',
            'wholesale_amount' => 'required|numeric',
            'unit' => 'required|numeric',
            'details' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);
        $data = $request->only([
            'item_name',
            'retail_amount',
            'wholesale_amount',
            'unit',
            'details',
            'status',
        ]);
        $data['company_id'] = Auth::user()->company_id;
        if (!isset($data['details'])) $data['details'] = '';
        if (!isset($data['unit'])) $data['unit'] = 1000;
        if (!isset($data['status'])) $data['status'] = 'active';
        
        $inventory = Inventory::create($data);
        
        // Log the activity
        $this->logCreate($inventory, 'Inventory Item', $inventory->item_name);
        
        return redirect()->route('inventory.index')->with('success', 'Item added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Inventory $inventory)
    {
        $suppliers = Supplier::where('company_id', Auth::user()->company_id)->get();
        return view('inventory.edit', compact('inventory', 'suppliers'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'retail_amount' => 'required|numeric',
            'wholesale_amount' => 'required|numeric',
            'unit' => 'required|numeric',
            'details' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);
        $data = $request->only([
            'item_name',
            'retail_amount',
            'wholesale_amount',
            'unit',
            'details',
            'status',
        ]);
        $data['company_id'] = Auth::user()->company_id;
        if (!isset($data['details'])) $data['details'] = '';
        if (!isset($data['unit'])) $data['unit'] = 1000;
        if (!isset($data['status'])) $data['status'] = 'active';
        
        $inventory->update($data);
        
        // Log the activity
        $this->logUpdate($inventory, 'Inventory Item', $inventory->item_name);
        
        return redirect()->route('inventory.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        // Log the activity before deletion
        $this->logDelete($inventory, 'Inventory Item', $inventory->item_name);
        
        if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
            Storage::disk('public')->delete($inventory->image);
        }

        $inventory->delete();
        return back()->with('success', 'Item deleted successfully.');
    }

    public function toggleStatus(Request $request, Inventory $inventory)
    {
        $oldStatus = $inventory->status;
        $inventory->status = $request->status === 'active' ? 'active' : 'inactive';
        $inventory->save();

        // Log the activity
        $this->logActivity(
            'Changed Inventory Status',
            "Item: {$inventory->item_name}, Status: {$oldStatus} → {$inventory->status}"
        );

        return response()->json([
            'success' => true,
            'status' => $inventory->status,
            'status_label' => ucfirst($inventory->status),
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!is_array($ids) || empty($ids)) {
            return redirect()->route('inventory.index')->with('error', 'No items selected for deletion.');
        }
        
        $inventories = Inventory::whereIn('id', $ids)->where('company_id', Auth::user()->company_id)->get();
        
        // Log the activity
        $itemNames = $inventories->pluck('item_name')->implode(', ');
        $this->logActivity(
            'Bulk Deleted Inventory Items',
            "Deleted {$inventories->count()} items: {$itemNames}"
        );
        
        foreach ($inventories as $inventory) {
            if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
                Storage::disk('public')->delete($inventory->image);
            }
            $inventory->delete();
        }
        return redirect()->route('inventory.index')->with('success', 'Selected items deleted successfully.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv',
        ]);
        
        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);
        $headerRow = $rows[1];
        $headerMap = [];
        foreach ($headerRow as $col => $name) {
            $headerMap[strtolower(trim($name))] = $col;
        }
        $count = 0;
        $companyId = Auth::user()->company_id;
        $importedItems = [];
        
        foreach (array_slice($rows, 1) as $row) {
            $data = [];
            $data['item_name'] = isset($headerMap['product name']) ? $row[$headerMap['product name']] ?? null : null;
            $data['retail_amount'] = isset($headerMap['retail price']) ? $row[$headerMap['retail price']] ?? null : null;
            $data['wholesale_amount'] = isset($headerMap['wholesale price']) ? $row[$headerMap['wholesale price']] ?? null : null;
            $data['details'] = isset($headerMap['detail']) ? ($row[$headerMap['detail']] ?? '') : '';
            // Use 'stock' or 'unit' column if present, else default to 1000
            if (isset($headerMap['stock']) && !empty($row[$headerMap['stock']])) {
                $importedStock = $row[$headerMap['stock']];
            } elseif (isset($headerMap['unit']) && !empty($row[$headerMap['unit']])) {
                $importedStock = $row[$headerMap['unit']];
            } else {
                $importedStock = 1000;
            }
            $data['company_id'] = $companyId;
            $data['status'] = 'active';
            // Only create/update if item_name and retail_amount are present
            if (!empty($data['item_name']) && !empty($data['retail_amount'])) {
                $existing = \App\Models\Inventory::where('company_id', $companyId)
                    ->where('item_name', $data['item_name'])
                    ->first();
                if ($existing) {
                    $existing->retail_amount = $data['retail_amount'];
                    $existing->wholesale_amount = $data['wholesale_amount'];
                    $existing->details = $data['details'];
                    $existing->unit = (int)$existing->unit + (int)$importedStock;
                    $existing->save();
                    $importedItems[] = "Updated: {$existing->item_name}";
                } else {
                    $data['unit'] = $importedStock;
                    $inventory = \App\Models\Inventory::create($data);
                    $importedItems[] = "Created: {$inventory->item_name}";
                }
                $count++;
            }
        }
        
        // Log the activity
        $this->logActivity(
            'Imported Inventory from Excel',
            "Imported {$count} items from file: " . $file->getClientOriginalName()
        );
        
        return redirect()->route('inventory.index')->with('success', "$count products imported successfully.");
    }

    public function exportExcel(Request $request)
    {
        // Log the activity
        $this->logExport('Inventory', 'Excel');
        
        $query = Inventory::where('company_id', Auth::user()->company_id);
        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }
        $inventories = $query->latest()->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray([
            ['Product Name', 'Retail Price', 'Wholesale Price', 'Unit', 'Details', 'Status']
        ], null, 'A1');
        $rowNum = 2;
        foreach ($inventories as $item) {
            $sheet->fromArray([
                $item->item_name,
                $item->retail_amount,
                $item->wholesale_amount,
                $item->unit,
                $item->details,
                $item->status,
            ], null, 'A' . $rowNum);
            $rowNum++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'inventory_export_' . date('Ymd_His') . '.xlsx';
        // Output to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function printCatalogue(Request $request)
    {
        // Log the activity
        $this->logExport('Inventory Catalogue', 'PDF');
        
        $query = Inventory::where('company_id', Auth::user()->company_id);
        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }
        $inventories = $query->latest()->get();
        $company = Auth::user()->company;
        return view('inventory.print_catalogue', compact('inventories', 'company'));
    }
}
