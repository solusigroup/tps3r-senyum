<?php

namespace App\Exports;

use App\Models\Pengangkutan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengangkutanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pengangkutan::with('karyawan')->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Wilayah',
            'Berat (Kg)',
            'Petugas',
            'Keterangan',
        ];
    }

    public function map($pengangkutan): array
    {
        return [
            $pengangkutan->id,
            $pengangkutan->tanggal->format('Y-m-d'),
            $pengangkutan->wilayah,
            $pengangkutan->volume,
            $pengangkutan->nama_petugas_display,
            $pengangkutan->keterangan,
        ];
    }
}
