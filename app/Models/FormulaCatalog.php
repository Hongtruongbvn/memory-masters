<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaCatalog extends Model
{
    use HasFactory;

    protected $table = 'formula_catalog';

    protected $fillable = [
        'title',
        'subject',
        'latex',
        'description',
        'image_path',
    ];

    protected $casts = [
    ];

    public function pages()
    {
        return $this->hasMany(Page::class, 'source', 'id');
    }
}
