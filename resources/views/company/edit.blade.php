@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Company</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops! </strong> Please fix the following errors:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('companies.update', $company->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select" required>
                <option value="wholesale" {{ old('type', $company->type) == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                <option value="retail" {{ old('type', $company->type) == 'retail' ? 'selected' : '' }}>Retail</option>
                <option value="both" {{ old('type', $company->type) == 'both' ? 'selected' : '' }}>Both</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cell_no" class="form-label">Cell Number</label>
            <input type="text" name="cell_no" id="cell_no" value="{{ old('cell_no', $company->cell_no) }}" class="form-control" placeholder="e.g. +1234567890">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email', $company->email) }}" class="form-control" placeholder="email@example.com">
        </div>

        <div class="mb-3">
            <label for="ntn" class="form-label">NTN</label>
            <input type="text" name="ntn" id="ntn" value="{{ old('ntn', $company->ntn) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tel_no" class="form-label">Telephone Number</label>
            <input type="text" name="tel_no" id="tel_no" value="{{ old('tel_no', $company->tel_no) }}" class="form-control" placeholder="e.g. +0987654321">
        </div>

        <hr>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="taxCash" class="form-label">Tax % (Cash)</label>
                <input type="number" step="0.01" name="taxCash" id="taxCash" value="{{ old('taxCash', $company->taxCash) }}" class="form-control" placeholder="e.g. 5">
            </div>

            <div class="col-md-4 mb-3">
                <label for="taxCard" class="form-label">Tax % (Card)</label>
                <input type="number" step="0.01" name="taxCard" id="taxCard" value="{{ old('taxCard', $company->taxCard) }}" class="form-control" placeholder="e.g. 5.5">
            </div>

            <div class="col-md-4 mb-3">
                <label for="taxOnline" class="form-label">Tax % (Online)</label>
                <input type="number" step="0.01" name="taxOnline" id="taxOnline" value="{{ old('taxOnline', $company->taxOnline) }}" class="form-control" placeholder="e.g. 6">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Company</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection
