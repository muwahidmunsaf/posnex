@extends('layouts.app')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h4 class="mb-3 text-danger text-center">Admin Password Reset</h4>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label for="email" class="form-label">Admin Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus value="{{ $email ?? old('email') }}" placeholder="Enter your admin email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Enter new password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirm new password">
            </div>
            <button type="submit" class="btn btn-danger w-100">Reset Password</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small text-decoration-none">Back to login</a>
        </div>
    </div>
</div>
@endsection 