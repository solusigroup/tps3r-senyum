<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemilahan extends Model
{
    protected $table = 'pemilahan';

    protected $fillable = [
        'tanggal',
        'kategori',
        'jenis',
        'berat',
        'karyawan_id',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'berat' => 'decimal:2',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }
}
