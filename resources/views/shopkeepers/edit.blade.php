@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Edit Shopkeeper</h2>
    
    <div class="mb-3">
        <a href="{{ route('shopkeepers.show', $shopkeeper) }}" class="btn btn-secondary">← Back to Shopkeeper</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('shopkeepers.update', $shopkeeper) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-3">
                    <label for="distributor_id" class="form-label">Distributor</label>
                    <select name="distributor_id" id="distributor_id" class="form-control" required>
                        <option value="">Select Distributor</option>
                        @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" {{ $shopkeeper->distributor_id == $distributor->id ? 'selected' : '' }}>
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
                    <input type="text" name="name" id="name" class="form-control" value="{{ $shopkeeper->name }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $shopkeeper->phone }}">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3">{{ $shopkeeper->address }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                @php
                    $openingOutstanding = $shopkeeper->transactions()->where('type', 'product_sold')->where('description', 'Opening Outstanding')->latest()->first();
                @endphp
                <div class="mb-3">
                    <label for="remaining_amount" class="form-label">Remaining Amount (Opening Outstanding)</label>
                    <input type="number" step="0.01" name="remaining_amount" id="remaining_amount" class="form-control" min="0" value="{{ $openingOutstanding ? $openingOutstanding->total_amount : 0 }}">
                </div>
                
                <button type="submit" class="btn btn-danger">Update Shopkeeper</button>
                <a href="{{ route('shopkeepers.show', $shopkeeper) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 