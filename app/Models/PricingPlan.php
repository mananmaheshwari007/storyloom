<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $table = 'pricing_plans';

    protected $fillable = [
        'plan_name',
        'price',
        'compare_price',
        'discount_label',
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
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
    ];

    /**
     * True only when there is a "was" amount above what we actually charge.
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->compare_price !== null
            && (float) $this->compare_price > (float) $this->price;
    }

    /**
     * The badge text. A label typed in the admin always wins; otherwise the
     * saving is worked out from the two amounts, so editors only have to keep
     * the numbers right.
     */
    public function getDiscountBadgeAttribute(): ?string
    {
        if (filled($this->discount_label)) {
            return $this->discount_label;
        }

        if (! $this->has_discount) {
            return null;
        }

        $off = round((1 - (float) $this->price / (float) $this->compare_price) * 100);

        return $off > 0 ? $off . '% OFF' : null;
    }
}
