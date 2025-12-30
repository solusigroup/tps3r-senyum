<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengangkutan extends Model
{
    protected $table = 'pengangkutan';

    protected $fillable = [
        'tanggal',
        'wilayah',
        'volume',
        'karyawan_id',
        'nama_petugas',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'volume' => 'decimal:2',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function getNamaPetugasDisplayAttribute(): string
    {
        return $this->karyawan?->nama ?? $this->nama_petugas ?? '-';
    }
}
