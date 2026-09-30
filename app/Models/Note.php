<?php

namespace App\Models;

use App\Helpers\AuthHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'subject', 
        'description',
        'is_private',
        'is_completed',
        'page_limit','study_method',
    'next_review_at',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];

public function getStudyStatus()
{
    $dueItems = SessionQueueItem::whereHas('session', function($query) {
            $query->where('note_id', $this->id)
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
        ->exists();

    if ($dueItems) {
        return 'ready_for_review';
    }

    $nextReview = SessionQueueItem::whereHas('session', function($query) {
            $query->where('note_id', $this->id)
                  ->where('user_id', AuthHelper::id());
        })
        ->where('status', 'done')
        ->where('next_review_at', '>', now())
        ->orderBy('next_review_at', 'asc')
        ->first();

    if ($nextReview) {
        return [
            'status' => 'scheduled',
            'next_review' => $nextReview->next_review_at
        ];
    }

    return 'new';
}
    
    protected $attributes = [
        'is_private' => true,
        'is_completed' => false,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('position');
    }

    public function studySessions()
    {
        return $this->hasMany(StudySession::class);
    }
}