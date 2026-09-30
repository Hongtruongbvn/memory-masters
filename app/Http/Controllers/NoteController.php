<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {        

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:normal,vocab,formula',
                
                'description' => 'nullable|string',
            ]);

            Log::info('Creating note with data:', $request->all());

            $note = Note::create([
                'user_id' => AuthHelper::id(),
                'title' => $request->title,
                'type' => $request->type,
                'subject' => $request->type === 'formula' ? $request->subject : null,
                'description' => $request->description,
                'is_private' => true,
                'is_completed' => false,
                'page_limit' => $request->type === 'normal' ? 100 : 50,
            ]);

            Log::info('Note created successfully:', ['note_id' => $note->id]);

            if ($request->type === 'normal') {
                return redirect()->route('normal-notes.show', $note->id)
                         ->with('success', 'Note created successfully!');
}
            else
            {
                return redirect()->route('pages.create', $note->id)
                            ->with('success', 'Note created successfully! Now add your first page.');
            }

        } catch (\Exception $e) {
            Log::error('Error creating note:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['error' =>$e->getMessage() ]);
        }
    }
    public function show(Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $pages = $note->pages()->orderBy('position')->get();
        return view('notes.show', compact('note', 'pages'));
    }
    public function destroy(Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('dashboard')
                        ->with('success', 'Note deleted successfully!');
    }
}