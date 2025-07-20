<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->orderBy('reminder_time', 'asc')->get();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'note' => 'required|string',
            'reminder_time' => 'nullable|date',
        ]);
        Note::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'note' => $request->note,
            'reminder_time' => $request->reminder_time,
            'is_done' => false,
        ]);
        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    public function edit(Note $note)
    {
        $this->authorizeNote($note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);
        // If only is_done is present (no note field), just update that
        if ($request->has('is_done') && !$request->has('note')) {
            $note->update(['is_done' => $request->is_done ? true : false]);
            return response()->json(['success' => true]);
        }
        // Otherwise, validate and update all fields
        $request->validate([
            'title' => 'nullable|string|max:255',
            'note' => 'required|string',
            'reminder_time' => 'nullable|date',
            'is_done' => 'nullable|boolean',
        ]);
        $note->update([
            'title' => $request->title,
            'note' => $request->note,
            'reminder_time' => $request->reminder_time,
            'is_done' => $request->has('is_done') ? $request->is_done : false,
        ]);
        return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $this->authorizeNote($note);
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }

    private function authorizeNote(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
