<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function create(Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $currentPages = $note->pages()->count();
        if ($currentPages >= $note->page_limit && !AuthHelper::isVip()) {
            return redirect()->route('notes.show', $note->id)
                            ->with('error', 'Page limit reached. Upgrade to VIP to add more pages.');
        }

        return view('pages.create', compact('note'));
    }

    public function store(Request $request, Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $currentPages = $note->pages()->count();
        if ($currentPages >= $note->page_limit && !AuthHelper::isVip()) {
            return redirect()->route('notes.show', $note->id)
                            ->with('error', 'Page limit reached. Upgrade to VIP to add more pages.');
        }

        $validationRules = [
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tags' => 'nullable|string|max:255',
        ];

        switch ($note->type) {
            case 'vocab':
                $validationRules['front_text'] = 'required|string|max:255';
                $validationRules['back_text'] = 'required|string|max:1000';
                break;
            
            case 'formula':
                $validationRules['front_text'] = 'nullable|string|max:255';
                $validationRules['back_text'] = 'nullable|string|max:1000';
                $validationRules['front_latex'] = 'nullable|string|max:1000';
                $validationRules['back_latex'] = 'nullable|string|max:1000';
                break;
            
            case 'normal':
            default:
                $validationRules['front_text'] = 'required|string|max:1000';
                $validationRules['back_text'] = 'required|string|max:1000';
                break;
        }

        $request->validate($validationRules);

        if ($note->type === 'formula') {
            if (empty($request->front_text) && empty($request->front_latex) && !$request->hasFile('front_image')) {
                return redirect()->back()->withErrors([
                    'front_text' => 'Please fill at least one field for front side (text, LaTeX, or image).'
                ]);
            }
        }

        $position = $note->pages()->max('position') + 1;

        $frontImagePath = null;
        $backImagePath = null;

        if ($request->hasFile('front_image')) {
            $frontImagePath = $request->file('front_image')->store('pages', 'public');
        }

        if ($request->hasFile('back_image')) {
            $backImagePath = $request->file('back_image')->store('pages', 'public');
        }

        Page::create([
            'note_id' => $note->id,
            'position' => $position,
            'front_text' => $request->front_text,
            'back_text' => $request->back_text,
            'front_latex' => $request->front_latex,
            'back_latex' => $request->back_latex,
            'image_front' => $frontImagePath,
            'image_back' => $backImagePath,
            'source' => 'user',
        ]);

        $message = 'Page added successfully!';

        if ($currentPages + 1 >= $note->page_limit) {
            $message .= ' Note is now complete!';
            $note->update(['is_completed' => true]);
        }

        if ($request->has('add_another')) {
            return redirect()->route('pages.create', $note->id)
                            ->with('success', $message);
        } else {
            return redirect()->route('notes.show', $note->id)
                            ->with('success', $message);
        }
    }

    public function edit(Page $page)
    {
        if ($page->note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        if ($page->note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $note = $page->note;

        $validationRules = [
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tags' => 'nullable|string|max:255',
        ];

        switch ($note->type) {
            case 'vocab':
                $validationRules['front_text'] = 'required|string|max:255';
                $validationRules['back_text'] = 'required|string|max:1000';
                break;
            
            case 'formula':
                $validationRules['front_text'] = 'nullable|string|max:255';
                $validationRules['back_text'] = 'nullable|string|max:1000';
                $validationRules['front_latex'] = 'nullable|string|max:1000';
                $validationRules['back_latex'] = 'nullable|string|max:1000';
                break;
            
            case 'normal':
            default:
                $validationRules['front_text'] = 'required|string|max:1000';
                $validationRules['back_text'] = 'required|string|max:1000';
                break;
        }

        $request->validate($validationRules);

        if ($note->type === 'formula') {
            if (empty($request->front_text) && empty($request->front_latex) && !$request->hasFile('front_image')) {
                return redirect()->back()->withErrors([
                    'front_text' => 'Please fill at least one field for front side (text, LaTeX, or image).'
                ]);
            }
        }

        $frontImagePath = $page->image_front;
        $backImagePath = $page->image_back;

        if ($request->has('remove_front_image') && $request->remove_front_image == '1') {
            if ($frontImagePath && Storage::disk('public')->exists($frontImagePath)) {
                Storage::disk('public')->delete($frontImagePath);
            }
            $frontImagePath = null;
        }

        if ($request->has('remove_back_image') && $request->remove_back_image == '1') {
            if ($backImagePath && Storage::disk('public')->exists($backImagePath)) {
                Storage::disk('public')->delete($backImagePath);
            }
            $backImagePath = null;
        }

        if ($request->hasFile('front_image')) {
            if ($frontImagePath && Storage::disk('public')->exists($frontImagePath)) {
                Storage::disk('public')->delete($frontImagePath);
            }
            $frontImagePath = $request->file('front_image')->store('pages', 'public');
        }

        if ($request->hasFile('back_image')) {
            if ($backImagePath && Storage::disk('public')->exists($backImagePath)) {
                Storage::disk('public')->delete($backImagePath);
            }
            $backImagePath = $request->file('back_image')->store('pages', 'public');
        }

        $page->update([
            'front_text' => $request->front_text,
            'back_text' => $request->back_text,
            'front_latex' => $request->front_latex,
            'back_latex' => $request->back_latex,
            'image_front' => $frontImagePath,
            'image_back' => $backImagePath,
        ]);

        return redirect()->route('notes.show', $page->note_id)
                        ->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        if ($page->note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        if ($page->image_front && Storage::disk('public')->exists($page->image_front)) {
            Storage::disk('public')->delete($page->image_front);
        }
        if ($page->image_back && Storage::disk('public')->exists($page->image_back)) {
            Storage::disk('public')->delete($page->image_back);
        }
        
        $noteId = $page->note_id;
        $page->delete();

        $pages = Page::where('note_id', $noteId)->orderBy('position')->get();
        foreach ($pages as $index => $pageItem) {
            $pageItem->update(['position' => $index + 1]);
        }

        $remainingPages = Page::where('note_id', $noteId)->count();
        $note = Note::find($noteId);
        if ($remainingPages < $note->page_limit) {
            $note->update(['is_completed' => false]);
        }

        return redirect()->route('notes.show', $noteId)
                        ->with('success', 'Page deleted successfully!');
    }

    public function reorder(Request $request, Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:pages,id',
        ]);

        foreach ($request->order as $position => $pageId) {
            Page::where('id', $pageId)->update(['position' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}