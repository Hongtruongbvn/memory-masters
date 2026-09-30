<?php
namespace App\Http\Controllers;
use App\Models\Note;
use App\Models\StudySession;
use App\Models\SessionQueueItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\AuthHelper;

class StudyController extends Controller
{
    public function show(Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        if ($note->pages()->count() === 0) {
            return redirect()->route('notes.show', $note->id)
                            ->with('error', 'Please add some pages to this note before studying.');
        }

        $studyMethods = $this->getStudyMethods();
        $nextReviewDate = $this->calculateNextReviewDate($note);
        
        return view('study.show', compact('note', 'studyMethods', 'nextReviewDate'));
    }

    public function start(Request $request, Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $request->validate([
            'study_method' => 'required|in:SM2,Leitner,Pomodoro,Custom',
            'study_time' => 'required|integer|min:5|max:120',
            'break_time' => 'required|integer|min:1|max:30',
        ]);

        $note->update([
            'study_method' => $request->study_method
        ]);

        $startedAt = Carbon::now();

        $session = StudySession::create([
            'user_id' => AuthHelper::id(),
            'note_id' => $note->id,
            'method' => $request->study_method,
            'config' => json_encode([
                'study_time' => $request->study_time,
                'break_time' => $request->break_time,
                'intervals' => $this->getIntervals($request->study_method),
                'current_study_start' => $startedAt->toISOString(),
                'total_elapsed_seconds' => 0,
            ]),
            'started_at' => $startedAt,
            'total_seconds' => 0,
        ]);

        $pages = $note->pages()->orderBy('position')->get()->shuffle();
        foreach ($pages as $index => $page) {
            SessionQueueItem::create([
                'session_id' => $session->id,
                'page_id' => $page->id,
                'queue_position' => $index + 1,
                'status' => 'pending',
                'next_review_at' => $startedAt,
                'interval_days' => 0,
                'repetition_count' => 0,
            ]);
        }

        return redirect()->route('study.session', $session)
                        ->with('success', 'Study session started!');
    }

    public function session(StudySession $session)
    {
        if ($session->user_id !== AuthHelper::id()) {
            abort(403);
        }

        if ($session->ended_at) {
            return redirect()->route('study.complete', $session);
        }

        $now = Carbon::now();
        $started = $session->started_at;
        
        if (!$started || $started->gt($now)) {
            $session->update(['started_at' => $now]);
            $started = $now;
        }

        $config = json_decode($session->config, true);
        $studyTime = $config['study_time'] ?? 25;
        
        $totalSessionSeconds = $session->total_seconds ?? 0;
        $currentStudyStart = isset($config['current_study_start']) ? Carbon::parse($config['current_study_start']) : $now;
        
        if ($totalSessionSeconds == 0) {
            $config['current_study_start'] = $now->toISOString();
            $session->update([
                'config' => json_encode($config),
                'total_seconds' => 0
            ]);
            $totalSessionSeconds = 0;
        } else {
            $currentElapsedSeconds = $now->diffInSeconds($currentStudyStart);
            $totalSessionSeconds = $totalSessionSeconds + $currentElapsedSeconds;
            
            $config['current_study_start'] = $now->toISOString();
            $config['total_elapsed_seconds'] = $totalSessionSeconds;
            $session->update([
                'config' => json_encode($config),
                'total_seconds' => $totalSessionSeconds
            ]);
        }
        
        $totalMinutes = floor($totalSessionSeconds / 60);
        $totalSeconds = $totalSessionSeconds % 60;
        $remainingStudyTime = max(0, $studyTime - floor($totalSessionSeconds / 60));

        $currentItem = $session->queueItems()
                            ->where(function($query) {
                                $query->where('status', 'pending')
                                      ->orWhere('status', 'again');
                            })
                            ->where(function($query) {
                                $query->where('next_review_at', '<=', now())
                                      ->orWhereNull('next_review_at');
                            })
                            ->orderBy('queue_position')
                            ->first();

        if (!$currentItem) {
            $session->update([
                'ended_at' => $now,
                'total_seconds' => $totalSessionSeconds,
            ]);
            
            $this->updateNextReviewDate($session->note);
            
            return redirect()->route('study.complete', $session);
        }

        $page = $currentItem->page;
        $note = $page->note;
        $studyMethods = $this->getStudyMethods();
        $methodConfig = $studyMethods[$session->method] ?? $studyMethods['SM2'];

        return view('study.session', compact(
            'session', 
            'currentItem', 
            'page', 
            'note', 
            'methodConfig',
            'totalMinutes',
            'totalSeconds',
            'remainingStudyTime',
            'studyTime'
        ));
    }

    public function review(Request $request, StudySession $session)
    {
        if ($session->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'quality' => 'required|integer|min:0|max:5',
            'response_time' => 'required|integer',
        ]);

        Review::create([
            'user_id' => AuthHelper::id(),
            'page_id' => $request->page_id,
            'session_id' => $session->id,
            'quality' => $request->quality,
            'response_time_sec' => $request->response_time,
        ]);

        $queueItem = SessionQueueItem::where('session_id', $session->id)
                                    ->where('page_id', $request->page_id)
                                    ->first();

        if ($queueItem) {
            $this->updateQueueItem($queueItem, $request->quality, $session);
        }

        $now = Carbon::now();
        $config = json_decode($session->config, true);
        $totalElapsedSeconds = $config['total_elapsed_seconds'] ?? 0;
        $currentStudyStart = isset($config['current_study_start']) ? Carbon::parse($config['current_study_start']) : $now;
        $currentElapsedSeconds = $now->diffInSeconds($currentStudyStart);
        $totalSessionSeconds = $totalElapsedSeconds + $currentElapsedSeconds;
        
        $config['total_elapsed_seconds'] = $totalSessionSeconds;
        $config['current_study_start'] = $now->toISOString();
        $session->update([
            'config' => json_encode($config),
            'total_seconds' => $totalSessionSeconds
        ]);

        $remainingItems = $session->queueItems()
                                ->where(function($query) {
                                    $query->where('status', 'pending')
                                          ->orWhere('status', 'again');
                                })
                                ->where(function($query) {
                                    $query->where('next_review_at', '<=', now())
                                      ->orWhereNull('next_review_at');
                                })
                                ->count();

        if ($remainingItems === 0) {
            $endedAt = now();
            
            $session->update([
                'ended_at' => $endedAt,
                'total_seconds' => $totalSessionSeconds,
            ]);

            $this->updateNextReviewDate($session->note);

            return response()->json([
                'success' => true,
                'completed' => true,
                'redirect_url' => route('study.complete', $session)
            ]);
        }

        return response()->json([
            'success' => true,
            'completed' => false
        ]);
    }

    public function saveTime(Request $request, StudySession $session)
    {
        if ($session->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $request->validate([
            'total_seconds' => 'required|integer',
        ]);

        $config = json_decode($session->config, true);
        $config['total_elapsed_seconds'] = $request->total_seconds;
        $config['current_study_start'] = Carbon::now()->toISOString();
        
        $session->update([
            'config' => json_encode($config),
            'total_seconds' => $request->total_seconds
        ]);

        return response()->json(['success' => true]);
    }

    public function complete(StudySession $session)
    {
        if ($session->user_id !== AuthHelper::id()) {
            abort(403);
        }

        if (!$session->ended_at) {
            $now = Carbon::now();
            $started = $session->started_at;
            
            if (!$started || $started->gt($now)) {
                $started = $session->created_at ?? $now->subMinutes(30);
                $session->update(['started_at' => $started]);
            }

            if (!$session->total_seconds || $session->total_seconds == 0) {
                $config = json_decode($session->config, true);
                $totalElapsedSeconds = $config['total_elapsed_seconds'] ?? 0;
                $currentStudyStart = isset($config['current_study_start']) ? Carbon::parse($config['current_study_start']) : $now;
                $currentElapsedSeconds = $now->diffInSeconds($currentStudyStart);
                $totalSeconds = $totalElapsedSeconds + $currentElapsedSeconds;
                
                $totalSeconds = max(60, $totalSeconds);
                
                $session->update([
                    'ended_at' => $now,
                    'total_seconds' => $totalSeconds,
                ]);
            } else {
                $session->update([
                    'ended_at' => $now,
                ]);
            }

            $this->updateNextReviewDate($session->note);
        }

        $totalReviews = $session->reviews()->count();
        $averageQuality = $session->reviews()->avg('quality') ?? 0;
        $totalTime = $session->total_seconds;

        return view('study.complete', compact('session', 'totalReviews', 'averageQuality', 'totalTime'));
    }

    public function break(StudySession $session)
    {
        if ($session->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $config = json_decode($session->config, true);
        $breakTime = $config['break_time'] ?? 5;

        return view('study.break', compact('session', 'breakTime'));
    }

    public function resumeFromBreak(StudySession $session)
    {
        if ($session->user_id !== AuthHelper::id()) {
            abort(403);
        }

        $now = Carbon::now();
        $config = json_decode($session->config, true);
        
        $currentStudyStart = isset($config['current_study_start']) ? Carbon::parse($config['current_study_start']) : $now;
        $elapsedBeforeBreak = $now->diffInSeconds($currentStudyStart);
        $totalElapsedSeconds = ($config['total_elapsed_seconds'] ?? 0) + $elapsedBeforeBreak;
        
        $config['current_study_start'] = $now->toISOString();
        $config['total_elapsed_seconds'] = $totalElapsedSeconds;
        
        $session->update([
            'config' => json_encode($config),
            'total_seconds' => $totalElapsedSeconds
        ]);

        return redirect()->route('study.session', $session);
    }

    public function getStudyMethods()
    {
        return [
            'SM2' => [
                'name' => 'SuperMemo SM-2',
                'description' => 'Spaced repetition algorithm for optimal memory retention',
                'default_study_time' => 25,
                'default_break_time' => 5,
                'intervals' => [1, 6, 16, 35, 62],
                'color' => 'blue',
                'icon' => 'fas fa-brain',
            ],
            'Leitner' => [
                'name' => 'Leitner System',
                'description' => 'Box-based system for progressive learning',
                'default_study_time' => 30,
                'default_break_time' => 10,
                'intervals' => [1, 2, 5, 10, 20],
                'color' => 'green',
                'icon' => 'fas fa-layer-group',
            ],
            'Pomodoro' => [
                'name' => 'Pomodoro Technique',
                'description' => 'Time management with focused intervals',
                'default_study_time' => 25,
                'default_break_time' => 5,
                'intervals' => [1, 7, 16],
                'color' => 'red',
                'icon' => 'fas fa-clock',
            ],
            'Custom' => [
                'name' => 'Custom Method',
                'description' => 'Create your own study intervals',
                'default_study_time' => 20,
                'default_break_time' => 5,
                'intervals' => [1, 3, 7, 14, 30],
                'color' => 'purple',
                'icon' => 'fas fa-cog',
            ],
        ];
    }

    private function getIntervals($method)
    {
        $methods = $this->getStudyMethods();
        return $methods[$method]['intervals'] ?? [1, 3, 7, 14, 30];
    }

    private function updateQueueItem($queueItem, $quality, $session)
    {
        $newRepetition = $queueItem->repetition_count + 1;
        
        $intervals = $this->getStudyMethods()[$session->method]['intervals'];    
        
        if ($newRepetition <= count($intervals)) {
            $interval = $intervals[$newRepetition - 1];
        } else {
            $interval = $intervals[0];     
            $newRepetition = 1;            
        }

        $queueItem->update([    
            'repetition_count' => $newRepetition,
            'interval_days' => $interval,
            'status' => 'done',
            'next_review_at' => now()->addDays($interval),
            'last_quality' => $quality,
            'last_reviewed_at' => now(),
        ]);
    }
    
    public function reviewSessions()
    {
        $user_id = AuthHelper::id();
        
        $reviewSessions = StudySession::where('user_id', $user_id)
            ->whereHas('queueItems', function($query) {
                $query->where('next_review_at', '<=', now())
                      ->where('status', 'done');
            })
            ->withCount(['queueItems as due_count' => function($query) {
                $query->where('next_review_at', '<=', now())
                      ->where('status', 'done');
            }])
            ->with('note')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('study.review-sessions', compact('reviewSessions'));
    }

    public function startReview(Note $note)
    {
        if ($note->user_id !== AuthHelper::id()) {
            abort(403);
        }

        if ($note->next_review_at && $note->next_review_at->gt(now())) {
            return redirect()->back()
                            ->with('error', 'Next review is scheduled for ' . $note->next_review_at->format('M d, Y'));
        }

        $startedAt = Carbon::now();

        $session = StudySession::create([
            'user_id' => AuthHelper::id(),
            'note_id' => $note->id,
            'method' => $note->study_method,
            'config' => json_encode([
                'study_time' => 25,
                'break_time' => 5,
                'intervals' => $this->getIntervals($note->study_method),
                'current_study_start' => $startedAt->toISOString(),
                'total_elapsed_seconds' => 0,
            ]),
            'started_at' => $startedAt,
            'total_seconds' => 0,
        ]);

        $queueItems = SessionQueueItem::whereHas('session', function($query) use ($note) {
                $query->where('note_id', $note->id)
                      ->where('user_id', AuthHelper::id());
            })
            ->where(function($query) {
                $query->where('status', 'pending')
                      ->orWhere('status', 'again')
                      ->orWhere(function($q) {
                          $q->where('status', 'done')
                            ->where('next_review_at', '<=', now());
                      });
            })
            ->with('page')
            ->get();

        foreach ($queueItems as $index => $queueItem) {
            SessionQueueItem::create([
                'session_id' => $session->id,
                'page_id' => $queueItem->page_id,
                'queue_position' => $index + 1,
                'status' => 'pending',
                'next_review_at' => $startedAt,
                'interval_days' => $queueItem->interval_days,
                'repetition_count' => $queueItem->repetition_count,
            ]);
        }

        $note->update(['next_review_at' => null]);

        return redirect()->route('study.session', $session)
                        ->with('success', 'Review session started!');
    }

    private function calculateNextReviewDate(Note $note)
    {
        if (!$note->study_method) {
            return null;
        }

        $userSessions = StudySession::where('note_id', $note->id)
                                    ->where('user_id', AuthHelper::id())
                                    ->pluck('id');

        $nextReview = SessionQueueItem::whereIn('session_id', $userSessions)
                                    ->where('status', 'done')
                                    ->where('next_review_at', '>', now())
                                    ->orderBy('next_review_at', 'asc')
                                    ->first();

        return $nextReview ? $nextReview->next_review_at : null;
    }

    private function updateNextReviewDate(Note $note)
    {
        $nextReviewDate = $this->calculateNextReviewDate($note);
        $note->update(['next_review_at' => $nextReviewDate]);
    }

    public function canReviewNow(Note $note)
    {
        if (!$note->study_method) {
            return true; 
        }

        return !$note->next_review_at || $note->next_review_at->lte(now());
    }
}