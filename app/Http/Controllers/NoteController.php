<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\Reading;

class NoteController extends Controller
{
    public function index($readingId)
    {
        $user = request()->user();
        $notes = $this->getNotes($user, $readingId);
        return response()->json($notes);
    }

    public function show($readingId, $noteId)
    {
        $user = request()->user();
        $note = $this->getNotes($user, $readingId, $noteId);
        return response()->json($note);
    }

    public function store($readingId, NoteRequest $request)
    {
        $validated = $request->validated();
        $note = Note::create($validated);
        return response()->json($note, 201);
    }

    public function destroy($readingId, $noteId)
    {
        $note = $this->getNotes(request()->user(), $readingId, $noteId);
        $note->deleteOrFail();
        return response()->json($note, 202);
    }

    public function update($readingId, $noteId, NoteRequest $request)
    {
        $note = $this->getNotes($request->user(), $readingId, $noteId);
        $note->updateOrFail($request->validated());
        return response()->json($note);
    }

    private function getNotes($user, $reading, $note = null)
    {
        $notes = Reading::readingNotes($user->id, $reading)->firstOrFail()->notes;
        if (!$note) {
            return $notes;
        }
        return $notes->whereIn('id', $note)->firstOrFail();
    }
}
