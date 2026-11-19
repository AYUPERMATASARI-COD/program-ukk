@extends('layout.layout')

@section('title', 'Dashboard Petugas')

@push('styles')
    <style>
        .petugas-hero { background: linear-gradient(135deg, #172554 0%, #1d4ed8 58%, #0f766e 100%); color: #fff; border-radius: 14px; overflow: hidden; position: relative; }
        .petugas-hero::after { content: ''; width: 220px; height: 220px; border: 28px solid rgba(255,255,255,.09); border-radius: 50%; position: absolute; right: -70px; top: -90px; }
        .petugas-card { border: 0; border-radius: 12px; box-shadow: 0 5px 18px rgba(15, 23, 42, .08); height: 100%; }
        .petugas-icon { width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 1.2rem; }
    </style>
@endpush

@section('content')
    <div class="petugas-hero p-4 p-lg-5 mb-4">
        <div class="position-relative" style="z-index: 1;">
        <div class="small text-white-50 text-uppercase fw-semibold mb-2">Panel operasional</div>
        <h1 class="h3 fw-bold mb-2">SELAMAT DATANG, {{ auth()->user()->name }}</h1>
        <p class="mb-0 text-white-50">Catat kendaraan masuk dan proses kendaraan keluar dengan cepat.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-4"><div class="card petugas-card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted small">Kendaraan di dalam</div><div class="fs-3 fw-bold">{{ $kendaraanDiDalam }}</div></div><span class="petugas-icon bg-success-subtle text-success"><i class="bi bi-car-front-fill"></i></span></div></div></div>
        <div class="col-sm-4"><div class="card petugas-card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted small">Transaksi hari ini</div><div class="fs-3 fw-bold">{{ $transaksiHariIni }}</div></div><span class="petugas-icon bg-primary-subtle text-primary"><i class="bi bi-receipt"></i></span></div></div></div>
        <div class="col-sm-4"><div class="card petugas-card"><div class="card-body d-flex justify-content-between"><div><div class="text-muted small">Selesai hari ini</div><div class="fs-3 fw-bold">{{ $transaksiSelesai }}</div></div><span class="petugas-icon bg-warning-subtle text-warning"><i class="bi bi-check2-circle"></i></span></div></div></div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5"><div class="card petugas-card"><div class="card-body p-4"><h5 class="mb-3">Aksi cepat</h5><a href="{{ route('petugas.transaksi.masuk') }}" class="btn btn-primary w-100 mb-2"><i class="bi bi-box-arrow-in-right"></i> Catat kendaraan masuk</a><a href="{{ route('petugas.transaksi.keluar') }}" class="btn btn-outline-primary w-100"><i class="bi bi-box-arrow-right"></i> Proses kendaraan keluar</a></div></div></div>
        <div class="col-lg-7"><div class="card petugas-card"><div class="card-body p-4"><h5 class="mb-3">Transaksi terbaru</h5><div class="table-responsive"><table class="table table-sm align-middle mb-0"><thead><tr><th>Plat</th><th>Masuk</th><th>Status</th></tr></thead><tbody>@forelse ($transaksiTerbaru as $transaksi)<tr><td class="fw-semibold">{{ $transaksi->kendaraan?->plat_nomor ?: '-' }}</td><td>{{ $transaksi->waktu_masuk?->format('H:i') ?: '-' }}</td><td><span class="badge {{ $transaksi->status === 'masuk' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($transaksi->status) }}</span></td></tr>@empty<tr><td colspan="3" class="text-center text-muted py-3">Belum ada transaksi.</td></tr>@endforelse</tbody></table></div></div></div></div>
    </div>
@endsection