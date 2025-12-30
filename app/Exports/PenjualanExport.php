<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Penjualan::orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Jenis Barang',
            'Berat (Kg)',
            'Harga per Kg',
            'Total',
            'Pembeli',
            'Keterangan',
        ];
    }

    public function map($penjualan): array
    {
        return [
            $penjualan->id,
            $penjualan->tanggal->format('Y-m-d'),
            $penjualan->jenis_barang,
            $penjualan->berat,
            $penjualan->harga_per_kg,
            $penjualan->total,
            $penjualan->pembeli,
            $penjualan->keterangan,
        ];
    }
}
