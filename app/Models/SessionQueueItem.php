<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionQueueItem extends Model
{
    use HasFactory;

    protected $table = 'session_queue_items';

    protected $fillable = [
        'session_id',
        'page_id',
        'queue_position',
        'status',
        'next_review_at',
        'ease_factor',
        'interval_days',
        'repetition_count',
        'last_quality',
        'last_reviewed_at',
    ];

    protected $casts = [
        'queue_position' => 'integer',
        'next_review_at' => 'datetime',
        'ease_factor' => 'float',
        'interval_days' => 'integer',
        'repetition_count' => 'integer',
        'last_quality' => 'integer',
        'last_reviewed_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(StudySession::class, 'session_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
