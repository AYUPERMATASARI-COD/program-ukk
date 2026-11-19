<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::orderBy('jenis_kendaraan')->paginate(10);

        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,bis,truk',
            'tarif_awal' => 'required|numeric|min:0',
            'tarif_perjam' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $tarif = Tarif::create($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Tambah tarif',
            'keterangan' => 'Tarif '.$tarif->jenis_kendaraan.' ditambahkan.',
        ]);

        return redirect()->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $validated = $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,bis,truk',
            'tarif_awal' => 'required|numeric|min:0',
            'tarif_perjam' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $tarif->update($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Ubah tarif',
            'keterangan' => 'Tarif '.$tarif->jenis_kendaraan.' diperbarui.',
        ]);

        return redirect()->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif)
    {
        $jenisKendaraan = $tarif->jenis_kendaraan;
        $tarif->delete();
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Hapus tarif',
            'keterangan' => 'Tarif '.$jenisKendaraan.' dihapus.',
        ]);

        return redirect()->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil dihapus.');
    }
}
