@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Application Backups</h3>
    <p class="text-muted">Download or restore from available backups. <strong>Restore will overwrite all data!</strong></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>File</th>
                <th>Size</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($backups as $file)
                <tr>
                    <td>{{ basename($file) }}</td>
                    <td>{{ Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local')->size($file) / 1024 | number_format(2) }} KB</td>
                    <td>{{ \Carbon\Carbon::createFromTimestamp(Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local')->lastModified($file))->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.backup.download', basename($file)) }}" class="btn btn-sm btn-primary">Download</a>
                        <button class="btn btn-sm btn-danger ms-2" onclick="confirmRestore('{{ basename($file) }}')">Restore</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No backups found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Restore Confirmation Modal -->
    <div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreModalLabel">Confirm Restore</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Are you sure you want to restore this backup? <br>This will <strong>overwrite all current data</strong> and cannot be undone.</p>
                    <p id="restoreFileName"></p>
                </div>
                <div class="modal-footer">
                    <form id="restoreForm" method="POST" action="{{ route('admin.restore') }}">
                        @csrf
                        <input type="hidden" name="file" id="restoreFileInput">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Restore</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function confirmRestore(file) {
    document.getElementById('restoreFileName').innerText = file;
    document.getElementById('restoreFileInput').value = file;
    var modal = new bootstrap.Modal(document.getElementById('restoreModal'));
    modal.show();
}
</script>
@endpush
@endsection 