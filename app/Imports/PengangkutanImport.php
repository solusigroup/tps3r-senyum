<?php

namespace App\Imports;

use App\Models\Pengangkutan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PengangkutanImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Pengangkutan([
            'tanggal' => Carbon::parse($row['tanggal']),
            'wilayah' => $row['wilayah'],
            'volume' => $row['berat'] ?? $row['volume'] ?? 0,
            'nama_petugas' => $row['petugas'] ?? $row['nama_petugas'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'wilayah' => 'required|string|max:255',
            'berat' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'petugas' => 'nullable|string|max:255',
            'nama_petugas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }
}
