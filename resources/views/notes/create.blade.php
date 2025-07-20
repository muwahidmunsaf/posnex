<form action="{{ route('notes.store') }}" method="POST" class="mb-4">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
    </div>
    <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea name="note" id="note" class="form-control" rows="3" required>{{ old('note') }}</textarea>
    </div>
    <div class="mb-3">
        <label for="reminder_time" class="form-label">Reminder Time</label>
        <input type="datetime-local" name="reminder_time" id="reminder_time" class="form-control" value="{{ old('reminder_time') }}">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('notes.index') }}" class="btn btn-secondary">Cancel</a>
</form> 