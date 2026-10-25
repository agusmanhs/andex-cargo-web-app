<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'phone',
        'email',
        'province_id',
        'regency_id',
        'address',
        'header_address',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function outgoingShipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'origin_branch_id');
    }

    public function incomingShipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'destination_branch_id');
    }

    public function outgoingManifests(): HasMany
    {
        return $this->hasMany(Manifest::class, 'origin_branch_id');
    }

    public function incomingManifests(): HasMany
    {
        return $this->hasMany(Manifest::class, 'destination_branch_id');
    }
}
