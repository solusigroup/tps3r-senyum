<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Iuran extends Model
{
    protected $table = 'iuran';

    protected $fillable = [
        'pelanggan_id',
        'bulan',
        'tahun',
        'jumlah',
        'status',
        'tanggal_bayar',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function setLunas(): void
    {
        $this->update([
            'status' => 'Lunas',
            'tanggal_bayar' => now(),
        ]);
    }
}
