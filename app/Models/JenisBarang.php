<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table = 'jenis_barang';

    protected $fillable = [
        'nama',
        'kategori',
        'harga_default',
        'satuan',
        'aktif',
    ];

    protected $casts = [
        'harga_default' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
