<?php

namespace App\Exports;

use App\Models\Pemilahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PemilahanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pemilahan::with('karyawan')->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Kategori',
            'Jenis',
            'Berat (Kg)',
            'Petugas',
            'Keterangan',
        ];
    }

    public function map($pemilahan): array
    {
        return [
            $pemilahan->id,
            $pemilahan->tanggal->format('Y-m-d'),
            $pemilahan->kategori,
            $pemilahan->jenis,
            $pemilahan->berat,
            $pemilahan->karyawan?->nama ?? '-',
            $pemilahan->keterangan,
        ];
    }
}
