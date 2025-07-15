@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add New Supplier</h3>

    <form method="POST" action="{{ route('suppliers.store') }}">
        @csrf

        <div class="mb-3">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Cell No</label>
            <input type="text" name="cell_no" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tel No</label>
            <input type="text" name="tel_no" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Country</label>
            <select name="country" class="form-control">
                <option value="">Select Country</option>
                <option value="Pakistan" selected>Pakistan</option>
                <option value="United States">United States</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="China">China</option>
                <option value="India">India</option>
                <option value="UAE">UAE</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Turkey">Turkey</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Thailand">Thailand</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
