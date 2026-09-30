<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public const TYPE_CARD = 'card';
    public const TYPE_NORMAL = 'normal';

    protected $fillable = [
        'note_id',
        'position',
        'type',
        'title',
        'content',
        'front_text',
        'back_text',
        'front_latex',
        'back_latex',
        'image_front',
        'image_back',
        'source',
        'meta',
    ];

    protected $casts = [
        'position' => 'integer',
        'meta' => 'array',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function queueItems()
    {
        return $this->hasMany(SessionQueueItem::class, 'page_id');
    }

    public function isNormal(): bool
    {
        return $this->type === self::TYPE_NORMAL;
    }

    public function getDisplayTitleAttribute(): ?string
    {
        if ($this->isNormal()) {
            return $this->title;
        }
        return $this->front_text ?? null;
    }

    public function getDisplayContentAttribute(): ?string
    {
        if ($this->isNormal()) {
            return $this->content;
        }
        return $this->back_text ?? null;
    }

    public function getMetaAttribute($value): array
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_null($value) || $value === '') {
            return [];
        }
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        return [];
    }
}
