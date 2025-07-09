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
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
