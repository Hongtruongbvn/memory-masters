<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'note_id',
        'method',
        'config', // json
        'started_at',
        'ended_at',
        'total_seconds',
    ];

    protected $casts = [
        'config' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'total_seconds' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function queueItems()
    {
        return $this->hasMany(SessionQueueItem::class, 'session_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'session_id');
    }
}
