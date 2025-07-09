@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Company Settings</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('company.settings.update') }}">
            @csrf

            <div class="mb-3">
                <label>Company Name</label>
                <input name="name" value="{{ old('name', $company->name) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone #</label>
                <input name="cell_no" value="{{ old('cell_no', $company->cell_no) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input name="email" value="{{ old('email', $company->email) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tax % (Cash)</label>
                <input name="taxCash" value="{{ old('taxCash', $company->taxCash) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tax % (Card)</label>
                <input name="taxCard" value="{{ old('taxCard', $company->taxCard) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tax % (Online)</label>
                <input name="taxOnline" value="{{ old('taxOnline', $company->taxOnline) }}" class="form-control">
            </div>

            <button class="btn btn-primary">Save Settings</button>
        </form>
    </div>
@endsection
