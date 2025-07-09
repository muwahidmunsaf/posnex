@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Add Employee</h3>
    <form action="{{ route('employees.store') }}" method="POST" class="mt-4" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" id="position" class="form-control" required value="{{ old('position') }}">
        </div>
        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" name="salary" id="salary" class="form-control" min="0" step="0.01" required value="{{ old('salary') }}">
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
        </div>
        <button type="submit" class="btn btn-primary">Add Employee</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection 