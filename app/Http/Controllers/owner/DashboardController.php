<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $pendapatanHariIni = Transaksi::where('status', 'keluar')
            ->whereDate('waktu_keluar', today())
            ->sum('total_bayar');
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        $kendaraanDiDalam = Transaksi::where('status', 'masuk')->count();
        $transaksiTerbaru = Transaksi::with('kendaraan')
            ->latest()
            ->limit(5)
            ->get();

        return view('owner.dashboard', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'kendaraanDiDalam',
            'transaksiTerbaru'
        ));
    }
}
