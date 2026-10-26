<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table = 'provinsi';

    protected $fillable = ['code', 'name', 'kode_provinsi', 'nama_provinsi'];

    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class, 'province_code', 'code');
    }

    public function kabupaten(): HasMany
    {
        return $this->regencies();
    }
}
