@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Customer #{{ $customer->id }}</h3>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Customer Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="wholesale" selected>Wholesale</option>
            </select>
            @error('type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="cel_no" class="form-label">Cell No</label>
            <input type="text" class="form-control" id="cel_no" name="cel_no" value="{{ old('cel_no', $customer->cel_no) }}" required>
            @error('cel_no') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer->email) }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="cnic" class="form-label">CNIC (00000-0000000-0)</label>
            <input type="text" class="form-control" id="cnic" name="cnic" value="{{ old('cnic', $customer->cnic) }}">
            @error('cnic') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $customer->city ?? '') }}">
            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address">{{ old('address', $customer->address) }}</textarea>
            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>
@endsection
