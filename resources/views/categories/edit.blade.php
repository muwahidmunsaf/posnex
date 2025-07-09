@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Category</h3>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="form-control" value="{{ $category->category_name }}" required>
        </div>

        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control">{{ $category->details }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
