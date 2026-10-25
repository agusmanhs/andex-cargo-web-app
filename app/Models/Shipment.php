<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'origin_branch_id',
        'destination_branch_id',
        'service_id',
        'customer_id',
        'created_by_user_id',
        'sender_name',
        'sender_phone',
        'sender_address',
        'origin_city',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'destination_city',
        'total_colly',
        'actual_weight',
        'volume_weight',
        'chargeable_weight',
        'tariff_per_kg',
        'shipping_cost',
        'packing_cost',
        'insurance_cost',
        'other_cost',
        'total_cost',
        'payment_type',
        'payment_status',
        'status',
        'is_manifested',
        'current_location',
        'delivered_at',
        'recipient_name',
        'pod_notes',
        'pod_photo',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'total_colly' => 'integer',
            'actual_weight' => 'decimal:2',
            'volume_weight' => 'decimal:2',
            'chargeable_weight' => 'decimal:2',
            'tariff_per_kg' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'packing_cost' => 'decimal:2',
            'insurance_cost' => 'decimal:2',
            'other_cost' => 'decimal:2',
            'total_cost' => 'decimal:2',
            'is_manifested' => 'boolean',
            'is_active' => 'boolean',
            'delivered_at' => 'datetime',
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

    public function service(): BelongsTo
    {
        return $this->belongsTo(ShippingService::class, 'service_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function trackingActivities(): HasMany
    {
        return $this->hasMany(TrackingActivity::class)->orderBy('happened_at', 'desc');
    }

    public function manifestItems(): HasMany
    {
        return $this->hasMany(ManifestItem::class);
    }
}
