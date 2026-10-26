<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorporateTariff extends Model
{
    protected $table = 'corporate_tariffs';

    protected $fillable = [
        'customer_id',
        'service_id',
        'from_kabupaten',
        'to_kabupaten',
        'contract_number',
        'price_per_kg',
        'min_weight',
        'min_price',
        'estimated_time',
        'start_date',
        'end_date',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kg' => 'decimal:2',
            'min_weight' => 'decimal:2',
            'min_price' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(ShippingService::class, 'service_id');
    }

    public function originRegency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'from_kabupaten', 'code');
    }

    public function destinationRegency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'to_kabupaten', 'code');
    }
}
