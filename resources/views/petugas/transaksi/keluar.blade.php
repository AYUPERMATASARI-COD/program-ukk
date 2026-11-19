@extends('layout.layout')

@section('title', 'Transaksi Keluar')

@push('styles')
	<style>
		.transaksi-hero {
			background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%);
			color: #fff;
			border-radius: 14px;
			overflow: hidden;
			position: relative;
		}
		.transaksi-hero::after {
			content: '';
			width: 220px;
			height: 220px;
			border: 28px solid rgba(255,255,255,.09);
			border-radius: 50%;
			position: absolute;
			right: -70px;
			top: -100px;
		}
		.transaksi-card {
			border: 0;
			border-radius: 12px;
			box-shadow: 0 5px 18px rgba(15, 23, 42, .08);
		}
		.transaksi-icon {
			width: 44px;
			height: 44px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 12px;
			background: #dbeafe;
			color: #1d4ed8;
			font-size: 1.25rem;
		}
		.transaksi-table thead th {
			color: #64748b;
			font-size: .75rem;
			letter-spacing: .04em;
			text-transform: uppercase;
			border-bottom-width: 1px;
		}
		.transaksi-table tbody tr:last-child td { border-bottom: 0; }
		.transaksi-table tbody tr { transition: background-color .2s ease; }
		.transaksi-table tbody tr:hover { background-color: #f8fafc; }
	</style>
@endpush

@section('content')
	<div class="transaksi-hero p-4 p-lg-5 mb-4">
		<div class="position-relative d-flex align-items-center gap-3" style="z-index: 1;">
			<span class="transaksi-icon"><i class="bi bi-box-arrow-right"></i></span>
			<div><div class="small text-white-50 text-uppercase fw-semibold mb-2">Operasional parkir</div><h1 class="h3 fw-bold mb-2">Transaksi Keluar</h1><p class="mb-0 text-white-50">Selesaikan kendaraan yang meninggalkan area parkir.</p></div>
		</div>
	</div>
	<div class="card transaksi-card"><div class="card-body p-3 p-lg-4">
		<div class="d-flex align-items-center gap-3 mb-4"><span class="transaksi-icon"><i class="bi bi-list-check"></i></span><div><h5 class="mb-1">Kendaraan di area parkir</h5><p class="text-muted small mb-0">Pilih kendaraan untuk menyelesaikan transaksi keluar.</p></div></div>
		<form method="POST" action="{{ route('petugas.transaksi.keluar.id') }}" class="row g-2 align-items-end mb-4">@csrf
			<div class="col-sm-7 col-md-5"><label for="transaksi_id" class="form-label fw-semibold">ID tiket masuk</label><input id="transaksi_id" name="transaksi_id" type="number" min="1" value="{{ old('transaksi_id') }}" class="form-control" placeholder="Masukkan ID tiket" required>@error('transaksi_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
			<div class="col-sm-auto"><button class="btn btn-primary" onclick="return confirm('Proses pembayaran untuk ID tiket ini?')"><i class="bi bi-cash-coin me-1"></i> Proses ID &amp; bayar</button></div>
		</form>
		<div class="table-responsive"><table class="table transaksi-table align-middle mb-0"><thead><tr><th>ID Masuk</th><th>Plat Nomor</th><th>Jenis</th><th>Pemilik</th><th>Waktu Masuk</th><th class="text-end">Aksi</th></tr></thead><tbody>
			@forelse ($transaksis as $transaksi)
				<tr><td><span class="badge bg-light text-dark">#{{ $transaksi->id }}</span></td><td><div class="d-flex align-items-center gap-3"><span class="transaksi-icon"><i class="bi bi-car-front-fill"></i></span><span class="fw-bold text-dark">{{ $transaksi->kendaraan?->plat_nomor ?: '-' }}</span></div></td><td><span class="badge rounded-pill bg-primary-subtle text-primary">{{ ucfirst($transaksi->kendaraan?->jenis_kendaraan ?: '-') }}</span></td><td class="text-muted">{{ $transaksi->kendaraan?->nama_pemilik ?: '-' }}</td><td class="text-muted"><i class="bi bi-clock me-1"></i>{{ $transaksi->waktu_masuk?->format('d/m/Y H:i') ?: '-' }}</td><td class="text-end"><form method="POST" action="{{ route('petugas.transaksi.keluar.proses', $transaksi) }}">@csrf<button class="btn btn-sm btn-primary" onclick="return confirm('Proses pembayaran dan kendaraan keluar?')"><i class="bi bi-cash-coin me-1"></i> Bayar &amp; keluar</button></form></td></tr>
			@empty
				<tr><td colspan="6" class="text-center text-muted py-5"><i class="bi bi-car-front fs-2 d-block mb-2 text-primary"></i>Tidak ada kendaraan di dalam.</td></tr>
			@endforelse
		</tbody></table></div>
	</div></div>
@endsection
