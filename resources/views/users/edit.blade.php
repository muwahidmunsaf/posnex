@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit User</h3>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>Company</label>
            <select name="company_id" class="form-select">
                <option value="">-- Select Company --</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <input type="text" name="role" class="form-control" value="{{ $user->role }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ $user->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$user->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Permissions</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="sales" id="perm_sales" {{ is_array(old('permissions', $user->permissions)) && in_array('sales', old('permissions', $user->permissions)) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_sales">Access Sales</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="inventory" id="perm_inventory" {{ is_array(old('permissions', $user->permissions)) && in_array('inventory', old('permissions', $user->permissions)) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_inventory">Access Inventory</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="reports" id="perm_reports" {{ is_array(old('permissions', $user->permissions)) && in_array('reports', old('permissions', $user->permissions)) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_reports">Access Reports</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="employees" id="perm_employees" {{ is_array(old('permissions', $user->permissions)) && in_array('employees', old('permissions', $user->permissions)) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_employees">Access Employees</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="expenses" id="perm_expenses" {{ is_array(old('permissions', $user->permissions)) && in_array('expenses', old('permissions', $user->permissions)) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_expenses">Access Expenses</label>
            </div>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
