<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingService extends Model
{
    protected $fillable = [
        'code',
        'name',
        'transport_type',
        'description',
        'min_weight',
        'estimated_time',
        'icon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'min_weight' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'service_id');
    }
}
