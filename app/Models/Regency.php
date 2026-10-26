<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Regency extends Model
{
    protected $table = 'kabupaten';

    protected $fillable = [
        'province_code',
        'code',
        'name',
        'kode_provinsi',
        'kode_kabupaten',
        'nama_kabupaten'
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function provinsi(): BelongsTo
    {
        return $this->province();
    }
}
