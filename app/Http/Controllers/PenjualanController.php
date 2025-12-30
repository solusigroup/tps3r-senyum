<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\JenisBarang;
use App\Exports\PenjualanExport;
use App\Imports\PenjualanImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::orderBy('tanggal', 'desc')
            ->paginate(15);

        $totalPendapatan = Penjualan::sum('total');
        $jenisBarang = JenisBarang::aktif()->orderBy('nama')->get();

        return view('penjualan.index', compact('penjualan', 'totalPendapatan', 'jenisBarang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_barang' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0',
            'harga_per_kg' => 'required|numeric|min:0',
            'pembeli' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Total dihitung otomatis di model
        $validated['total'] = $validated['berat'] * $validated['harga_per_kg'];

        Penjualan::create($validated);

        return redirect()->route('penjualan.index')
            ->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();

        return redirect()->route('penjualan.index')
            ->with('success', 'Data penjualan berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new PenjualanExport, 'penjualan_' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new PenjualanImport, $request->file('file'));
            return redirect()->route('penjualan.index')
                ->with('success', 'Data penjualan berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('penjualan.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function template()
    {
        $headers = ['tanggal', 'jenis_barang', 'berat', 'harga_per_kg', 'pembeli', 'keterangan'];
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'template_penjualan.csv');
    }
}
