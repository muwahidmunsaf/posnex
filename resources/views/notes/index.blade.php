@extends('layouts.app')

@section('content')
<style>
    .gradient-blue {
        background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
        color: #fff;
    }
    .gradient-green {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        color: #fff;
    }
    .gradient-purple {
        background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);
        color: #fff;
    }
    .gradient-orange {
        background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
        color: #fff;
    }
    .gradient-pink {
        background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);
        color: #fff;
    }
    .gradient-teal {
        background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
        color: #fff;
    }
</style>
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Notes & Reminders</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Add Note Form in Card -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <span class="fw-semibold"><i class="bi bi-plus-circle me-2"></i>Add Note / Reminder</span>
                </div>
                <div class="card-body">
                    @include('notes.create')
                </div>
            </div>
        </div>
    </div>
    <!-- Notes Cards Grid -->
    @php
        $gradients = ['gradient-blue', 'gradient-green', 'gradient-purple', 'gradient-orange', 'gradient-pink', 'gradient-teal'];
    @endphp
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($notes as $i => $note)
            @php $gradient = $gradients[$i % count($gradients)]; @endphp
            <div class="col">
                <div class="card shadow h-100 {{ $gradient }} border-0">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-1 fw-bold fs-5">{{ $note->title ?? '(No Title)' }}</div>
                            <div class="mb-2">{{ $note->note }}</div>
                            <div class="text-light small mb-2">
                                @if($note->reminder_time)
                                    <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($note->reminder_time)->format('d-M-Y H:i') }}
                                @endif
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-auto">
                            @if(!$note->is_done)
                                <form method="POST" action="{{ route('notes.update', $note) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="note" value="{{ $note->note }}">
                                    <input type="hidden" name="title" value="{{ $note->title }}">
                                    <input type="hidden" name="reminder_time" value="{{ $note->reminder_time }}">
                                    <input type="hidden" name="is_done" value="1">
                                    <button type="submit" class="btn btn-link p-0 text-white" title="Mark as Done" style="font-size:1.3em;"><i class="bi bi-check-circle-fill"></i></button>
                                </form>
                            @endif
                            <a href="{{ route('notes.edit', $note) }}" class="btn btn-link p-0 text-white" title="Edit" style="font-size:1.3em;"><i class="bi bi-pencil-square"></i></a>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Delete this note?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-white" title="Delete" style="font-size:1.3em;"><i class="bi bi-trash-fill"></i></button>
                            </form>
                            <span class="ms-auto badge rounded-pill px-3 py-2 {{ $note->is_done ? 'bg-light text-success' : (empty($note->reminder_time) ? 'bg-light text-secondary' : (\Carbon\Carbon::parse($note->reminder_time)->isPast() ? 'bg-light text-warning' : 'bg-light text-info') ) }}">
                                {{ $note->is_done ? 'Done' : (empty($note->reminder_time) ? 'Pending' : (\Carbon\Carbon::parse($note->reminder_time)->isPast() ? 'Due' : 'Upcoming')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col"><div class="alert alert-info text-center">No notes or reminders found.</div></div>
        @endforelse
    </div>
</div>
@endsection 