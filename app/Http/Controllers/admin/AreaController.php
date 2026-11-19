<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areas = AreaParkir::when($request->search, function ($query, $search) {
            $query->where('nama_area', 'like', "%{$search}%");
        })
            ->orderBy('nama_area')
            ->paginate(10)
            ->withQueryString();

        return view('admin.area.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.area.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_area' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $area = AreaParkir::create($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Tambah area parkir',
            'keterangan' => 'Area '.$area->nama_area.' ditambahkan dengan kapasitas '.$area->kapasitas.' kendaraan.',
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Area parkir berhasil ditambahkan.');
    }

    public function edit(AreaParkir $area)
    {
        return view('admin.area.edit', compact('area'));
    }

    public function update(Request $request, AreaParkir $area)
    {
        $validated = $request->validate([
            'nama_area' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $area->update($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Ubah area parkir',
            'keterangan' => 'Area '.$area->nama_area.' diperbarui dengan kapasitas '.$area->kapasitas.' kendaraan.',
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Area parkir berhasil diperbarui.');
    }

    public function destroy(AreaParkir $area)
    {
        $namaArea = $area->nama_area;
        $area->delete();
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Hapus area parkir',
            'keterangan' => 'Area '.$namaArea.' dihapus.',
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Area parkir berhasil dihapus.');
    }
}
