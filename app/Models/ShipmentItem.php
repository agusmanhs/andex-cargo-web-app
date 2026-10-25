<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentItem extends Model
{
    protected $fillable = [
        'shipment_id',
        'item_name',
        'colly_count',
        'length_cm',
        'width_cm',
        'height_cm',
        'actual_weight_kg',
        'volume_weight_kg',
        'chargeable_weight_kg',
    ];

    protected function casts(): array
    {
        return [
            'colly_count' => 'integer',
            'length_cm' => 'decimal:2',
            'width_cm' => 'decimal:2',
            'height_cm' => 'decimal:2',
            'actual_weight_kg' => 'decimal:2',
            'volume_weight_kg' => 'decimal:2',
            'chargeable_weight_kg' => 'decimal:2',
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
