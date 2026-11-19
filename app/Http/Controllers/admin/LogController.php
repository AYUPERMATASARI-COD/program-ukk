<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = LogAktivitas::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where('aktivitas', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->when($request->tanggal, function ($query, $tanggal) {
                $query->whereDate('created_at', $tanggal);
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.log.index', compact('logs'));
    }
}
