<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

class NormalNoteController extends Controller
{
    public function show(Note $note)
    {
        if ($note->user_id !== AuthHelper::id() || $note->type !== 'normal') {
            abort(403);
        }

        return view('normal-notes.show', compact('note'));
    }
    public function updateContent(Request $request, Note $note)
    {
        
        if ($note->user_id !== AuthHelper::id() || $note->type !== 'normal') {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:10000',
        ]);

        $page = $note->pages()->first();
        
        if ($page) {
            $page->update([
                'front_text' => $note->title,
                'back_text' => $request->input('content'),
            ]);
        } else {
            Page::create([
                'note_id' => $note->id,
                'position' => 1,
                'front_text' => $note->title,
                'back_text' => $request->input('content'),
                'source' => 'user',
            ]);
        }

        return redirect()->route('normal-notes.show', $note->id)
                        ->with('success', 'Content updated successfully!');
    }
    public function destroy(Note $note)
    {
        if ($note->user_id !== AuthHelper::id() || $note->type !== 'normal') {
            abort(403);
        }

        $note->delete();

        return redirect()->route('dashboard')
                        ->with('success', 'Note deleted successfully!');
    }
}