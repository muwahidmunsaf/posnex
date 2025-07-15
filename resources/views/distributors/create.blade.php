@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Add Distributor</h2>
    <form action="{{ route('distributors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control">
        </div>
        <div class="mb-3">
            <label for="commission_rate" class="form-label">Commission Rate (%)</label>
            <input type="number" step="0.01" name="commission_rate" id="commission_rate" class="form-control">
        </div>
        <button type="submit" class="btn btn-danger">Add Distributor</button>
        <a href="{{ route('distributors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 