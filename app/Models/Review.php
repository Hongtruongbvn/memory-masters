<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'page_id',
        'session_id',
        'quality',
        'response_time_sec',
        'notes',
    ];

    protected $casts = [
        'quality' => 'integer',
        'response_time_sec' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function session()
    {
        return $this->belongsTo(StudySession::class, 'session_id');
    }
}
