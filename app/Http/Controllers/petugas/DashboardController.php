<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        $kendaraanDiDalam = Transaksi::where('status', 'masuk')->count();
        $transaksiSelesai = Transaksi::where('status', 'keluar')
            ->whereDate('waktu_keluar', today())
            ->count();
        $transaksiTerbaru = Transaksi::with('kendaraan')
            ->latest()
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact(
            'transaksiHariIni',
            'kendaraanDiDalam',
            'transaksiSelesai',
            'transaksiTerbaru'
        ));
    }
}
