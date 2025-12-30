<?php

namespace App\Http\Controllers;

use App\Models\Pengangkutan;
use App\Models\Karyawan;
use App\Exports\PengangkutanExport;
use App\Imports\PengangkutanImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PengangkutanController extends Controller
{
    public function index()
    {
        $pengangkutan = Pengangkutan::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        $karyawan = Karyawan::where('status', 'aktif')->get();

        return view('pengangkutan.index', compact('pengangkutan', 'karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'wilayah' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'nama_petugas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Pengangkutan::create($validated);

        return redirect()->route('pengangkutan.index')
            ->with('success', 'Data pengangkutan berhasil disimpan.');
    }

    public function edit(Pengangkutan $pengangkutan)
    {
        $karyawan = Karyawan::where('status', 'aktif')->get();
        return view('pengangkutan.edit', compact('pengangkutan', 'karyawan'));
    }

    public function update(Request $request, Pengangkutan $pengangkutan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'wilayah' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'nama_petugas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $pengangkutan->update($validated);

        return redirect()->route('pengangkutan.index')
            ->with('success', 'Data pengangkutan berhasil diperbarui.');
    }

    public function destroy(Pengangkutan $pengangkutan)
    {
        $pengangkutan->delete();

        return redirect()->route('pengangkutan.index')
            ->with('success', 'Data pengangkutan berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new PengangkutanExport, 'pengangkutan_' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new PengangkutanImport, $request->file('file'));
            return redirect()->route('pengangkutan.index')
                ->with('success', 'Data pengangkutan berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('pengangkutan.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function template()
    {
        $headers = ['tanggal', 'wilayah', 'berat', 'petugas', 'keterangan'];
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'template_pengangkutan.csv');
    }
}
