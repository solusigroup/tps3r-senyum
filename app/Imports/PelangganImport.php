<?php

namespace App\Imports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PelangganImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Pelanggan([
            'nama' => $row['nama'],
            'alamat' => $row['alamat'] ?? null,
            'rt' => $row['rt'] ?? null,
            'rw' => $row['rw'] ?? null,
            'dusun' => $row['dusun'] ?? null,
            'desa' => $row['desa'] ?? null,
            'kecamatan' => $row['kecamatan'] ?? null,
            'kab_kota' => $row['kab_kota'] ?? $row['kabkota'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'iuran_bulanan' => $row['iuran_bulanan'] ?? 0,
            'status' => $row['status'] ?? 'aktif',
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kab_kota' => 'nullable|string|max:100',
            'kabkota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'iuran_bulanan' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:aktif,nonaktif,tidak_aktif',
        ];
    }
}
