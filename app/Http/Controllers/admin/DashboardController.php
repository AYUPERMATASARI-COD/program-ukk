<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalArea = AreaParkir::count();
        $totalKendaraan = Kendaraan::count();
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalArea',
            'totalKendaraan',
            'transaksiHariIni'
        ));
    }
}
