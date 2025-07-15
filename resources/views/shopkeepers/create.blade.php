@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Add Shopkeeper</h2>
    
    @if($distributor_id)
        <div class="mb-3">
            <a href="{{ route('distributors.show', $distributor_id) }}" class="btn btn-secondary">← Back to Distributor</a>
        </div>
    @else
        <div class="mb-3">
            <a href="{{ route('shopkeepers.index') }}" class="btn btn-secondary">← Back to Shopkeepers</a>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('shopkeepers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="distributor_id" class="form-label">Distributor</label>
                    <select name="distributor_id" id="distributor_id" class="form-control" required>
                        <option value="">Select Distributor</option>
                        @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" {{ $distributor_id == $distributor->id ? 'selected' : '' }}>
                                {{ $distributor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('distributor_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="remaining_amount" class="form-label">Remaining Amount (Opening Outstanding)</label>
                    <input type="number" step="0.01" name="remaining_amount" id="remaining_amount" class="form-control" min="0" value="0">
                </div>
                
                <button type="submit" class="btn btn-danger">Add Shopkeeper</button>
                <a href="{{ $distributor_id ? route('distributors.show', $distributor_id) : route('shopkeepers.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 