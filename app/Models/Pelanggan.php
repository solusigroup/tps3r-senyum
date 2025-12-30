<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kab_kota',
        'no_hp',
        'iuran_bulanan',
        'status',
    ];

    protected $casts = [
        'iuran_bulanan' => 'decimal:2',
    ];

    public function iuran(): HasMany
    {
        return $this->hasMany(Iuran::class);
    }
}
