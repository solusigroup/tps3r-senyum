<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'tanggal',
        'jenis_barang',
        'berat',
        'harga_per_kg',
        'total',
        'pembeli',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'berat' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Auto-calculate total when saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total = $model->berat * $model->harga_per_kg;
        });
    }
}
