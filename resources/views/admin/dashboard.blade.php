@extends('layout.layout')

@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        .dashboard-hero {
            background: linear-gradient(135deg, #172554 0%, #1d4ed8 58%, #0f766e 100%);
            color: #fff;
            border-radius: 14px;
            overflow: hidden;
            position: relative;
        }
        .dashboard-hero::after {
            content: '';
            width: 220px;
            height: 220px;
            border: 28px solid rgba(255,255,255,.09);
            border-radius: 50%;
            position: absolute;
            right: -70px;
            top: -90px;
        }
        .metric-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .08);
            height: 100%;
        }
        .metric-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.2rem;
        }
        .shortcut-link {
            border: 1px solid #e2e8f0;
            color: #334155;
            transition: .2s ease;
        }
        .shortcut-link:hover {
            border-color: #2563eb;
            color: #1d4ed8;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-hero p-4 p-lg-5 mb-4">
        <div class="position-relative" style="z-index: 1;">
            <div class="small text-white-50 text-uppercase fw-semibold mb-2">Ringkasan operasional</div>
            <h1 class="h3 fw-bold mb-2">SELAMAT DATANG, {{ auth()->user()->name }}</h1>
            <p class="mb-0 text-white-50">Pantau aktivitas sistem parkir hari ini dari satu tempat.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card metric-card">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div><div class="text-muted small mb-2">Total User</div><div class="fs-3 fw-bold">{{ $totalUser }}</div><div class="small text-success mt-1"><i class="bi bi-check-circle"></i> Akun terdaftar</div></div>
                    <span class="metric-icon bg-primary-subtle text-primary"><i class="bi bi-people-fill"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card metric-card">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div><div class="text-muted small mb-2">Area Parkir</div><div class="fs-3 fw-bold">{{ $totalArea }}</div><div class="small text-muted mt-1">Lokasi aktif</div></div>
                    <span class="metric-icon bg-success-subtle text-success"><i class="bi bi-geo-alt-fill"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card metric-card">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div><div class="text-muted small mb-2">Kendaraan</div><div class="fs-3 fw-bold">{{ $totalKendaraan }}</div><div class="small text-muted mt-1">Terdaftar di sistem</div></div>
                    <span class="metric-icon bg-warning-subtle text-warning"><i class="bi bi-car-front-fill"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card metric-card">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div><div class="text-muted small mb-2">Transaksi Hari Ini</div><div class="fs-3 fw-bold">{{ $transaksiHariIni }}</div><div class="small text-muted mt-1">{{ now()->translatedFormat('d F Y') }}</div></div>
                    <span class="metric-icon bg-info-subtle text-info"><i class="bi bi-receipt-cutoff"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div><h5 class="mb-1">Akses cepat</h5><p class="text-muted small mb-0">Kelola data utama sistem parkir</p></div>
                        <i class="bi bi-grid-1x2 text-primary fs-4"></i>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6"><a href="{{ route('admin.tarif.index') }}" class="shortcut-link rounded-3 p-3 d-flex align-items-center gap-3 text-decoration-none"><i class="bi bi-cash-coin fs-4"></i><span><strong class="d-block">Data Tarif</strong><small class="text-muted">Atur biaya parkir</small></span></a></div>
                        <div class="col-sm-6"><a href="{{ route('admin.area.index') }}" class="shortcut-link rounded-3 p-3 d-flex align-items-center gap-3 text-decoration-none"><i class="bi bi-geo-alt fs-4"></i><span><strong class="d-block">Area Parkir</strong><small class="text-muted">Kelola lokasi</small></span></a></div>
                        <div class="col-sm-6"><a href="{{ route('admin.kendaraan.index') }}" class="shortcut-link rounded-3 p-3 d-flex align-items-center gap-3 text-decoration-none"><i class="bi bi-car-front fs-4"></i><span><strong class="d-block">Kendaraan</strong><small class="text-muted">Lihat kendaraan</small></span></a></div>
                        <div class="col-sm-6"><a href="{{ route('admin.user.index') }}" class="shortcut-link rounded-3 p-3 d-flex align-items-center gap-3 text-decoration-none"><i class="bi bi-person-gear fs-4"></i><span><strong class="d-block">Data User</strong><small class="text-muted">Kelola pengguna</small></span></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3"><div><h5 class="mb-1">Status sistem</h5><p class="text-muted small mb-0">Informasi layanan saat ini</p></div><span class="badge bg-success-subtle text-success">Online</span></div>
                    <div class="d-flex align-items-center gap-3 py-3 border-bottom"><span class="metric-icon bg-success-subtle text-success"><i class="bi bi-database-check"></i></span><div><strong class="d-block">Database terhubung</strong><small class="text-muted">Data siap digunakan</small></div></div>
                    <div class="d-flex align-items-center gap-3 py-3"><span class="metric-icon bg-primary-subtle text-primary"><i class="bi bi-shield-check"></i></span><div><strong class="d-block">Akses administrator</strong><small class="text-muted">{{ auth()->user()->username }}</small></div></div>
                </div>
            </div>
        </div>
    </div>
@endsection