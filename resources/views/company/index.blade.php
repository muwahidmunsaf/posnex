@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Companies</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3">+ Add Company</a>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>Cell No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->type }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->cell_no }}</td>
                        <td>
                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <!-- Delete Button triggers modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $company->id }}">
                                Delete
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{ $company->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $company->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-top">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $company->id }}">Confirm Delete
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $company->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>

                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
