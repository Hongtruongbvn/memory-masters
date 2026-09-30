<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\StudySession;
use App\Helpers\AuthHelper;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = AuthHelper::id();
        
        $notes = Note::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $recentSessions = StudySession::where('user_id', $userId)
                                    ->with('note')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();

        $stats = [
            'total_notes' => $notes->count(),
            'completed_notes' => $notes->where('is_completed', true)->count(),
            'total_pages' => 0,
            'total_study_time' => StudySession::where('user_id', $userId)->sum('total_seconds')
        ];

        foreach ($notes as $note) {
            $stats['total_pages'] += $note->pages()->count();
        }

        return view('auth.dashboard', compact('notes', 'recentSessions', 'stats'));
    }
}