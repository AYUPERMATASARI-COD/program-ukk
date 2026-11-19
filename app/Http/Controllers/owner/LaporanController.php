<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $tanggalMulai = isset($validated['tanggal_mulai'])
            ? Carbon::parse($validated['tanggal_mulai'])->startOfDay()
            : null;
        $tanggalSelesai = isset($validated['tanggal_selesai'])
            ? Carbon::parse($validated['tanggal_selesai'])->endOfDay()
            : null;

        $transaksis = Transaksi::with(['kendaraan', 'user'])
            ->where('status', 'keluar')
            ->when($tanggalMulai, fn ($query, $date) => $query->where('waktu_keluar', '>=', $date))
            ->when($tanggalSelesai, fn ($query, $date) => $query->where('waktu_keluar', '<=', $date))
            ->latest('waktu_keluar')
            ->paginate(15)
            ->withQueryString();

        $pendapatan = (clone $transaksis->getCollection())->sum('total_bayar');

        return view('owner.laporan.index', compact('transaksis', 'pendapatan'));
    }
}
