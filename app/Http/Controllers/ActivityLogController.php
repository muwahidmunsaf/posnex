<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user() || !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }
        $query = ActivityLog::query()->orderByDesc('created_at');
        if ($request->filled('user')) {
            $query->where('user_name', 'like', '%' . $request->user . '%');
        }
        if ($request->filled('role')) {
            $query->where('user_role', $request->role);
        }
        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        $logs = $query->paginate(20);
        return view('activity_logs.index', [
            'logs' => $logs,
            'user' => $request->user,
            'role' => $request->role,
            'action' => $request->action,
            'date' => $request->date,
        ]);
    }
}
