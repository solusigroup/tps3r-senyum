<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'nama',
        'nik',
        'jabatan',
        'no_hp',
        'alamat',
        'tanggal_masuk',
        'status',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function pengangkutan(): HasMany
    {
        return $this->hasMany(Pengangkutan::class);
    }

    public function pemilahan(): HasMany
    {
        return $this->hasMany(Pemilahan::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
