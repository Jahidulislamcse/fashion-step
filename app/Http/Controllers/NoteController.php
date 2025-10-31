<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return response()->json(Note::with('user')->latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'noteable_type' => 'required|string',
            'noteable_id' => 'required|integer',
            'body' => 'required|string',
        ]);

        $data['user_id'] = auth()->id() ?? 1;

        $note = Note::create($data);
        return response()->json(['message' => 'Note added', 'data' => $note]);
    }
}
