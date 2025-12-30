<?php

namespace App\Imports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PenjualanImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Penjualan([
            'tanggal' => Carbon::parse($row['tanggal']),
            'jenis_barang' => $row['jenis_barang'],
            'berat' => $row['berat'],
            'harga_per_kg' => $row['harga_per_kg'],
            'pembeli' => $row['pembeli'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'jenis_barang' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0',
            'harga_per_kg' => 'required|numeric|min:0',
            'pembeli' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }
}
