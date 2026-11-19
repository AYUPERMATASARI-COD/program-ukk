<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $kendaraans = Kendaraan::with('area')
            ->when($request->search, function ($query, $search) {
                $query->where('plat_nomor', 'like', "%{$search}%")
                    ->orWhere('nama_pemilik', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        $areas = AreaParkir::orderBy('nama_area')->get();

        return view('admin.kendaraan.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plat_nomor' => 'required|string|max:20|unique:kendaraans,plat_nomor',
            'jenis_kendaraan' => 'required|in:motor,mobil,bis,truk',
            'nama_pemilik' => 'nullable|string|max:100',
            'area_id' => 'nullable|exists:area_parkirs,id',
        ]);

        $kendaraan = Kendaraan::create($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Tambah kendaraan',
            'keterangan' => 'Kendaraan '.$kendaraan->plat_nomor.' ditambahkan.',
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        $areas = AreaParkir::orderBy('nama_area')->get();

        return view('admin.kendaraan.edit', compact('kendaraan', 'areas'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'plat_nomor' => ['required', 'string', 'max:20', Rule::unique('kendaraans', 'plat_nomor')->ignore($kendaraan->id)],
            'jenis_kendaraan' => 'required|in:motor,mobil,bis,truk',
            'nama_pemilik' => 'nullable|string|max:100',
            'area_id' => 'nullable|exists:area_parkirs,id',
        ]);

        $kendaraan->update($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Ubah kendaraan',
            'keterangan' => 'Data kendaraan '.$kendaraan->plat_nomor.' diperbarui.',
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $platNomor = $kendaraan->plat_nomor;
        $kendaraan->delete();
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Hapus kendaraan',
            'keterangan' => 'Kendaraan '.$platNomor.' dihapus.',
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
