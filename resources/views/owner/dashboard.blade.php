@extends('layout.layout')

@section('title', 'Dashboard Owner')

@push('styles')
    <style>
        .owner-hero { background: linear-gradient(135deg, #172554 0%, #1d4ed8 58%, #0f766e 100%); color: #fff; border-radius: 14px; overflow: hidden; position: relative; }
        .owner-hero::after { content: ''; width: 220px; height: 220px; border: 28px solid rgba(255,255,255,.09); border-radius: 50%; position: absolute; right: -70px; top: -90px; }
        .owner-card { border: 0; border-radius: 12px; box-shadow: 0 5px 18px rgba(15, 23, 42, .08); height: 100%; }
        .owner-icon { width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 1.2rem; }
    </style>
@endpush

@section('content')
    <div class="owner-hero p-4 p-lg-5 mb-4">
        <div class="position-relative" style="z-index: 1;">
            <div class="small text-white-50 text-uppercase fw-semibold mb-2">Ringkasan bisnis</div>
            <h1 class="h3 fw-bold mb-2">SELAMAT DATANG, {{ auth()->user()->name }}</h1>
            <p class="mb-0 text-white-50">Pantau performa parkir dan pendapatan hari ini.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3"><div class="card owner-card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted small">Pendapatan hari ini</div><div class="fs-4 fw-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div></div><span class="owner-icon bg-success-subtle text-success"><i class="bi bi-cash-stack"></i></span></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card owner-card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted small">Transaksi hari ini</div><div class="fs-3 fw-bold">{{ $transaksiHariIni }}</div></div><span class="owner-icon bg-primary-subtle text-primary"><i class="bi bi-receipt"></i></span></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card owner-card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted small">Kendaraan di dalam</div><div class="fs-3 fw-bold">{{ $kendaraanDiDalam }}</div></div><span class="owner-icon bg-warning-subtle text-warning"><i class="bi bi-car-front-fill"></i></span></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card owner-card"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="text-muted small">Laporan</div><strong>Siap dilihat</strong></div><span class="owner-icon bg-info-subtle text-info"><i class="bi bi-file-earmark-bar-graph"></i></span></div></div></div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5"><div class="card owner-card"><div class="card-body p-4"><h5 class="mb-3">Akses owner</h5><a href="{{ route('owner.laporan.index') }}" class="btn btn-primary w-100"><i class="bi bi-file-earmark-bar-graph"></i> Buka laporan transaksi</a></div></div></div>
        <div class="col-lg-7"><div class="card owner-card"><div class="card-body p-4"><h5 class="mb-3">Transaksi terbaru</h5><div class="table-responsive"><table class="table table-sm align-middle mb-0"><thead><tr><th>Plat</th><th>Waktu keluar</th><th>Total</th></tr></thead><tbody>@forelse ($transaksiTerbaru as $transaksi)<tr><td class="fw-semibold">{{ $transaksi->kendaraan?->plat_nomor ?: '-' }}</td><td>{{ $transaksi->waktu_keluar?->format('d/m/Y H:i') ?: '-' }}</td><td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted py-3">Belum ada transaksi.</td></tr>@endforelse</tbody></table></div></div></div></div>
    </div>
@endsection