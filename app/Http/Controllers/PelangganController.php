<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Exports\PelangganExport;
use App\Imports\PelangganImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::withCount(['iuran as iuran_lunas_count' => function($query) {
                $query->where('status', 'Lunas');
            }])
            ->orderBy('nama')
            ->paginate(20);

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kab_kota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'iuran_bulanan' => 'required|numeric|min:0',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kab_kota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'iuran_bulanan' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new PelangganExport, 'pelanggan_' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new PelangganImport, $request->file('file'));
            return redirect()->route('pelanggan.index')
                ->with('success', 'Data pelanggan berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('pelanggan.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function template()
    {
        $headers = ['nama', 'alamat', 'rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kab_kota', 'no_hp', 'iuran_bulanan', 'status'];
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'template_pelanggan.csv');
    }
}
