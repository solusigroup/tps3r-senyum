<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kas::query();

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $kas = $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->paginate(20);

        // Calculate summary
        $totalMasuk = Kas::where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar = Kas::where('jenis', 'Keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('kas.index', compact('kas', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function create()
    {
        return view('kas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Masuk,Keluar',
            'akun_lawan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'bukti' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('kas-bukti', 'public');
        }

        Kas::create($validated);

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil ditambahkan');
    }

    public function edit(Kas $kas)
    {
        return view('kas.edit', compact('kas'));
    }

    public function update(Request $request, Kas $kas)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Masuk,Keluar',
            'akun_lawan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'bukti' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            // Delete old file if exists
            if ($kas->bukti) {
                Storage::disk('public')->delete($kas->bukti);
            }
            $validated['bukti'] = $request->file('bukti')->store('kas-bukti', 'public');
        }

        $kas->update($validated);

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil diperbarui');
    }

    public function destroy(Kas $kas)
    {
        // Delete file if exists
        if ($kas->bukti) {
            Storage::disk('public')->delete($kas->bukti);
        }

        $kas->delete();

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil dihapus');
    }
}
