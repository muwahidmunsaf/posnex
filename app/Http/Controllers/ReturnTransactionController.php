<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnTransaction;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class ReturnTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnTransaction::with(['sale.customer', 'item']);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('customer')) {
            $query->whereHas('sale.customer', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer . '%');
            });
        }
        if ($request->filled('item')) {
            $query->whereHas('item', function($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->item . '%');
            });
        }
        if ($request->filled('processed_by')) {
            $query->where('processed_by', 'like', '%' . $request->processed_by . '%');
        }
        $returns = $query->orderByDesc('created_at')->paginate(20);
        return view('returns.index', compact('returns'));
    }
} 