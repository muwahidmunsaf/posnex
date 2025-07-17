@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cloud Backup Settings</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card mt-4">
        <div class="card-body">
            @if($cloudBackup)
                <p><strong>Connected Google Account:</strong> {{ $cloudBackup->name }} ({{ $cloudBackup->email }})</p>
                <a href="{{ route('cloud-backup.google.redirect') }}" class="btn btn-primary mb-3">Change Google Drive Account</a>
                <hr>
                <form method="POST" action="{{ route('cloud-backup.settings.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="frequency" class="form-label">Backup Frequency</label>
                        <select name="frequency" id="frequency" class="form-select" required>
                            <option value="daily" {{ $cloudBackup->frequency == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $cloudBackup->frequency == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $cloudBackup->frequency == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Backup Time (24h format)</label>
                        <input type="time" name="time" id="time" class="form-control" value="{{ $cloudBackup->time ?? '02:00' }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Schedule</button>
                </form>
                @if($cloudBackup->last_run_at)
                    <p class="mt-3 text-muted">Last backup run: {{ $cloudBackup->last_run_at->format('Y-m-d H:i') }}</p>
                @endif
            @else
                <p>No Google Drive account connected.</p>
                <a href="{{ route('cloud-backup.google.redirect') }}" class="btn btn-success">Connect Google Drive Account</a>
            @endif
        </div>
    </div>
</div>
@endsection 