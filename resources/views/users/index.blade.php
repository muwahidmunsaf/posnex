@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User Management</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
            <a href="{{ route('register') }}" class="btn btn-primary btn-md me-3 mb-3">Create New User</a>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Role</th>
                <th>Status</th>
                <th>Timer</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ optional($user->company)->name ?? '-' }}</td>
                <td>{{ $user->role ?? '-' }}</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $user->id }}" {{ $user->status ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $user->status ? 'Active' : 'Inactive' }}</label>
                    </div>
                </td>
                <td>{{ $user->inactive_at ? $user->inactive_at->toFormattedDateString() : '-' }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function () {
            const userId = this.getAttribute('data-id');
            fetch(`/users/${userId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(res => res.json())
              .then(data => {
                  if (data.success) {
                      this.nextElementSibling.textContent = data.status ? 'Active' : 'Inactive';
                  }
              });
        });
    });
</script>
@endsection
