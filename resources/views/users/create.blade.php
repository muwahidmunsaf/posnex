@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Add User</h3>
    <form action="{{ route('users.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="sales" id="perm_sales" {{ is_array(old('permissions')) && in_array('sales', old('permissions')) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_sales">Access Sales</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="inventory" id="perm_inventory" {{ is_array(old('permissions')) && in_array('inventory', old('permissions')) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_inventory">Access Inventory</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="reports" id="perm_reports" {{ is_array(old('permissions')) && in_array('reports', old('permissions')) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_reports">Access Reports</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="employees" id="perm_employees" {{ is_array(old('permissions')) && in_array('employees', old('permissions')) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_employees">Access Employees</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="expenses" id="perm_expenses" {{ is_array(old('permissions')) && in_array('expenses', old('permissions')) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_expenses">Access Expenses</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection 