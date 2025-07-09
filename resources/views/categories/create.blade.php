@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Category</h3>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
