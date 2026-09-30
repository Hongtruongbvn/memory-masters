<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipPlan extends Model
{
    use HasFactory;

    protected $table = 'vip_plans';

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'features' => 'array',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'plan_id');
    }
}
