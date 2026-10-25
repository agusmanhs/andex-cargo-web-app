<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tariff extends Model
{
    protected $fillable = [
        'service_id',
        'from_regency',
        'to_regency',
        'price_per_kg',
        'min_weight',
        'min_price',
        'estimated_time',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'min_weight' => 'decimal:2',
            'min_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(ShippingService::class, 'service_id');
    }
}
