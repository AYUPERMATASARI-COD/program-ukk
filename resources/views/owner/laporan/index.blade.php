@extends('layout.layout')

@section('title', 'Laporan Transaksi')

@push('styles')
	<style>
		.laporan-hero {
			background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%);
			color: #fff;
			border-radius: 14px;
			overflow: hidden;
			position: relative;
		}
		.laporan-hero::after {
			content: '';
			width: 220px;
			height: 220px;
			border: 28px solid rgba(255,255,255,.09);
			border-radius: 50%;
			position: absolute;
			right: -70px;
			top: -100px;
		}
		.laporan-card {
			border: 0;
			border-radius: 12px;
			box-shadow: 0 5px 18px rgba(15, 23, 42, .08);
		}
		.laporan-table thead th {
			color: #64748b;
			font-size: .75rem;
			letter-spacing: .04em;
			text-transform: uppercase;
			border-bottom-width: 1px;
		}
		.laporan-table tbody tr:last-child td { border-bottom: 0; }
		.laporan-table tbody tr { transition: background-color .2s ease; }
		.laporan-table tbody tr:hover { background-color: #f8fafc; }
		.laporan-icon {
			width: 38px;
			height: 38px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 11px;
			background: #dbeafe;
			color: #1d4ed8;
		}
	</style>
@endpush

@section('content')
	<div class="laporan-hero p-4 p-lg-5 mb-4">
		<div class="position-relative d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="z-index: 1;">
			<div>
				<div class="small text-white-50 text-uppercase fw-semibold mb-2">Ringkasan keuangan</div>
				<h1 class="h3 fw-bold mb-2">Laporan Transaksi</h1>
				<p class="mb-0 text-white-50">Riwayat transaksi kendaraan yang sudah selesai.</p>
			</div>
			<div class="text-md-end">
				<div class="small text-white-50 mb-1">Total pendapatan</div>
				<div class="h4 fw-bold mb-0">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
			</div>
		</div>
	</div>

	<div class="card laporan-card"><div class="card-body p-3 p-lg-4">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
			<div><h5 class="mb-1">Daftar transaksi</h5><p class="text-muted small mb-0">{{ $transaksis->total() }} transaksi selesai tercatat</p></div>
			<form method="GET" class="m-0"><div class="row g-2 align-items-end">
				<div class="col-sm-auto"><label class="form-label small text-muted mb-1">Dari tanggal</label><input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control"></div>
				<div class="col-sm-auto"><label class="form-label small text-muted mb-1">Sampai tanggal</label><input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control"></div>
				<div class="col-auto"><button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filter</button></div>
				<div class="col-auto"><a href="{{ route('owner.laporan.index') }}" class="btn btn-light text-secondary">Reset</a></div>
			</div></form>
		</div>
		<div class="table-responsive"><table class="table laporan-table align-middle mb-0"><thead><tr><th>Waktu keluar</th><th>Plat nomor</th><th>Jenis</th><th>Petugas</th><th class="text-end">Total bayar</th></tr></thead><tbody>
			@forelse ($transaksis as $transaksi)
				<tr><td class="text-muted"><i class="bi bi-clock me-1"></i>{{ $transaksi->waktu_keluar?->format('d/m/Y H:i') ?: '-' }}</td><td><div class="d-flex align-items-center gap-3"><span class="laporan-icon"><i class="bi bi-car-front-fill"></i></span><span class="fw-bold text-dark">{{ $transaksi->kendaraan?->plat_nomor ?: '-' }}</span></div></td><td><span class="badge rounded-pill bg-primary-subtle text-primary">{{ ucfirst($transaksi->kendaraan?->jenis_kendaraan ?: '-') }}</span></td><td class="text-muted">{{ $transaksi->user?->name ?: '-' }}</td><td class="text-end fw-semibold">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td></tr>
			@empty
				<tr><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-receipt fs-2 d-block mb-2 text-primary"></i>Belum ada transaksi sesuai filter.</td></tr>
			@endforelse
		</tbody></table></div>
		@if ($transaksis->hasPages())<div class="mt-4">{{ $transaksis->links() }}</div>@endif
	</div></div>
@endsection
