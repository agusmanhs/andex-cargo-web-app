<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManifestItem extends Model
{
    protected $fillable = [
        'manifest_id',
        'shipment_id',
        'status',
        'scanned_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
        ];
    }

    public function manifest(): BelongsTo
    {
        return $this->belongsTo(Manifest::class);
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
