@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Supplier</h3>

    <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" value="{{ $supplier->supplier_name }}" required>
        </div>

        <div class="mb-3">
            <label>Cell No</label>
            <input type="text" name="cell_no" class="form-control" value="{{ $supplier->cell_no }}" required>
        </div>

        <div class="mb-3">
            <label>Tel No</label>
            <input type="text" name="tel_no" class="form-control" value="{{ $supplier->tel_no }}">
        </div>

        <div class="mb-3">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control" value="{{ $supplier->contact_person }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $supplier->email }}">
        </div>

        <div class="mb-3">
            <label>Country</label>
            <select name="country" class="form-control">
                <option value="">Select Country</option>
                <option value="Pakistan" {{ $supplier->country == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                <option value="United States" {{ $supplier->country == 'United States' ? 'selected' : '' }}>United States</option>
                <option value="United Kingdom" {{ $supplier->country == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                <option value="China" {{ $supplier->country == 'China' ? 'selected' : '' }}>China</option>
                <option value="India" {{ $supplier->country == 'India' ? 'selected' : '' }}>India</option>
                <option value="UAE" {{ $supplier->country == 'UAE' ? 'selected' : '' }}>UAE</option>
                <option value="Saudi Arabia" {{ $supplier->country == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                <option value="Turkey" {{ $supplier->country == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                <option value="Afghanistan" {{ $supplier->country == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                <option value="Bangladesh" {{ $supplier->country == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                <option value="Thailand" {{ $supplier->country == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                <option value="Other" {{ $supplier->country == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
