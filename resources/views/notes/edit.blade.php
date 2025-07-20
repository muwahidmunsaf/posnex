@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Note / Reminder</h3>
    <form action="{{ route('notes.update', $note) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $note->title) }}">
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control" rows="3" required>{{ old('note', $note->note) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="reminder_time" class="form-label">Reminder Time</label>
            <input type="datetime-local" name="reminder_time" id="reminder_time" class="form-control" value="{{ old('reminder_time', $note->reminder_time ? \Carbon\Carbon::parse($note->reminder_time)->format('Y-m-d\TH:i') : '') }}">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_done" id="is_done" class="form-check-input" value="1" {{ old('is_done', $note->is_done) ? 'checked' : '' }}>
            <label for="is_done" class="form-check-label">Mark as Done</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('notes.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection 