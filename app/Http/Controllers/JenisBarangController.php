<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index()
    {
        $jenisBarang = JenisBarang::orderBy('kategori')->orderBy('nama')->paginate(20);
        
        $ringkasan = JenisBarang::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('jenis-barang.index', compact('jenisBarang', 'ringkasan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Organik,Anorganik,Residu',
            'harga_default' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:20',
        ]);

        $validated['harga_default'] = $validated['harga_default'] ?? 0;
        $validated['satuan'] = $validated['satuan'] ?? 'kg';

        JenisBarang::create($validated);

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil ditambahkan');
    }

    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Organik,Anorganik,Residu',
            'harga_default' => 'nullable|numeric|min:0',
            'satuan' => 'nullable|string|max:20',
            'aktif' => 'boolean',
        ]);

        $jenisBarang->update($validated);

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil diupdate');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        $jenisBarang->delete();

        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis barang berhasil dihapus');
    }

    // API untuk dropdown
    public function list(Request $request)
    {
        $query = JenisBarang::aktif();
        
        if ($request->kategori) {
            $query->byKategori($request->kategori);
        }

        return response()->json($query->orderBy('nama')->get());
    }
}
