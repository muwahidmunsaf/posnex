@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Activity Logs</h3>
    <form method="GET" class="row g-3 align-items-end mb-3">
        <div class="col-auto">
            <label for="user" class="form-label mb-0">User</label>
            <input type="text" name="user" id="user" class="form-control" value="{{ $user ?? '' }}">
        </div>
        <div class="col-auto">
            <label for="role" class="form-label mb-0">Role</label>
            <select name="role" id="role" class="form-select">
                <option value="">All</option>
                <option value="admin" {{ ($role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="superadmin" {{ ($role ?? '') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                <option value="manager" {{ ($role ?? '') == 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="employee" {{ ($role ?? '') == 'employee' ? 'selected' : '' }}>Employee</option>
            </select>
        </div>
        <div class="col-auto">
            <label for="action" class="form-label mb-0">Action</label>
            <input type="text" name="action" id="action" class="form-control" value="{{ $action ?? '' }}">
        </div>
        <div class="col-auto">
            <label for="date" class="form-label mb-0">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $date ?? '' }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request('user') || request('role') || request('action') || request('date'))
                <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary ms-2">Clear</a>
            @endif
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Role</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $log->user_name }}</td>
                    <td>{{ $log->user_role }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->details }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No logs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $logs->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection 