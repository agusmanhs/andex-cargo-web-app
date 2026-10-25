<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manifest extends Model
{
    use HasFactory;

    protected $fillable = [
        'manifest_number',
        'origin_branch_id',
        'destination_branch_id',
        'transport_type',
        'vehicle_plate_number',
        'driver_name',
        'driver_phone',
        'vendor_name',
        'departure_time',
        'estimated_arrival',
        'arrived_at',
        'status',
        'total_shipments',
        'total_colly',
        'total_weight',
        'created_by_user_id',
        'received_by_user_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'departure_time' => 'datetime',
            'estimated_arrival' => 'datetime',
            'arrived_at' => 'datetime',
            'total_shipments' => 'integer',
            'total_colly' => 'integer',
            'total_weight' => 'decimal:2',
        ];
    }

    public function originBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'origin_branch_id');
    }

    public function destinationBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'destination_branch_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ManifestItem::class);
    }
}
