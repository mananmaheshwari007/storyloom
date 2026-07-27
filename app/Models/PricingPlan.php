<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $table = 'pricing_plans';

    protected $fillable = [
        'plan_name',
        'price',
        'duration',
        'features',
        'button_text',
        'button_url',
        'popular_plan',
        'status'
    ];

    protected $casts = [
        'features' => 'array',
        'popular_plan' => 'boolean',
        'price' => 'decimal:2'
    ];
}
