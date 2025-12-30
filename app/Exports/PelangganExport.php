<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PelangganExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pelanggan::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Alamat',
            'RT',
            'RW',
            'Dusun',
            'Desa',
            'Kecamatan',
            'Kab/Kota',
            'No HP',
            'Iuran Bulanan',
            'Status',
        ];
    }

    public function map($pelanggan): array
    {
        return [
            $pelanggan->id,
            $pelanggan->nama,
            $pelanggan->alamat,
            $pelanggan->rt,
            $pelanggan->rw,
            $pelanggan->dusun,
            $pelanggan->desa,
            $pelanggan->kecamatan,
            $pelanggan->kab_kota,
            $pelanggan->no_hp,
            $pelanggan->iuran_bulanan,
            $pelanggan->status,
        ];
    }
}
