<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingActivity extends Model
{
    protected $fillable = [
        'shipment_id',
        'manifest_id',
        'status',
        'title',
        'description',
        'location',
        'created_by_user_id',
        'happened_at',
    ];

    protected function casts(): array
    {
        return [
            'happened_at' => 'datetime',
        ];
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function manifest(): BelongsTo
    {
        return $this->belongsTo(Manifest::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
