@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Distributor Details</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $distributor->name }}</h5>
            <p class="card-text"><strong>Phone:</strong> {{ $distributor->phone }}</p>
            <p class="card-text"><strong>Address:</strong> {{ $distributor->address }}</p>
            <p class="card-text"><strong>Commission Rate:</strong> {{ $distributor->commission_rate }}%</p>
        </div>
    </div>
    <h4>Shopkeepers</h4>
    <a href="{{ route('shopkeepers.create', ['distributor_id' => $distributor->id]) }}" class="btn btn-danger mb-3">Add Shopkeeper</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shopkeepers as $shopkeeper)
            <tr>
                <td>{{ $shopkeeper->name }}</td>
                <td>{{ $shopkeeper->phone }}</td>
                <td>{{ $shopkeeper->address }}</td>
                <td>
                    <a href="{{ route('shopkeepers.show', $shopkeeper) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('shopkeepers.edit', $shopkeeper) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('shopkeepers.destroy', $shopkeeper) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this shopkeeper?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('distributors.history', $distributor) }}" class="btn btn-secondary mt-3">View History</a>
</div>
@endsection 