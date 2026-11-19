@extends('layout.layout')

@section('title', 'Data Tarif')

@push('styles')
	<style>
		.tarif-hero {
			background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%);
			color: #fff;
			border-radius: 14px;
			overflow: hidden;
			position: relative;
		}
		.tarif-hero::after {
			content: '';
			width: 220px;
			height: 220px;
			border: 28px solid rgba(255,255,255,.09);
			border-radius: 50%;
			position: absolute;
			right: -70px;
			top: -100px;
		}
		.tarif-table-card {
			border: 0;
			border-radius: 12px;
			box-shadow: 0 5px 18px rgba(15, 23, 42, .08);
		}
		.tarif-icon {
			width: 38px;
			height: 38px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 11px;
			background: #dbeafe;
			color: #1d4ed8;
		}
		.tarif-table thead th {
			color: #64748b;
			font-size: .75rem;
			letter-spacing: .04em;
			text-transform: uppercase;
			border-bottom-width: 1px;
		}
		.tarif-table tbody tr:last-child td { border-bottom: 0; }
		.tarif-table tbody tr { transition: background-color .2s ease; }
		.tarif-table tbody tr:hover { background-color: #f8fafc; }
	</style>
@endpush

@section('content')
	<div class="tarif-hero p-4 p-lg-5 mb-4">
		<div class="position-relative d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="z-index: 1;">
			<div>
				<div class="small text-white-50 text-uppercase fw-semibold mb-2">Pengaturan biaya</div>
				<h1 class="h3 fw-bold mb-2">Data Tarif</h1>
				<p class="mb-0 text-white-50">Atur biaya parkir berdasarkan jenis kendaraan.</p>
			</div>
			<a href="{{ route('admin.tarif.create') }}" class="btn btn-light text-primary fw-semibold">
				<i class="bi bi-plus-lg me-1"></i> Tambah Tarif
			</a>
		</div>
	</div>

	<div class="card tarif-table-card">
		<div class="card-body p-3 p-lg-4">
			<div class="mb-4">
				<h5 class="mb-1">Daftar tarif parkir</h5>
				<p class="text-muted small mb-0">{{ $tarifs->total() }} tarif kendaraan terdaftar dalam sistem</p>
			</div>
			<div class="table-responsive">
			<table class="table tarif-table align-middle mb-0">
				<thead>
					<tr>
						<th>Jenis Kendaraan</th>
						<th>Tarif Awal</th>
						<th>Tarif Per Jam</th>
						<th>Keterangan</th>
						<th class="text-end">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($tarifs as $tarif)
						<tr>
								<td>
									<div class="d-flex align-items-center gap-3">
										<span class="tarif-icon"><i class="bi bi-car-front-fill"></i></span>
										<span class="fw-semibold text-dark">{{ ucfirst($tarif->jenis_kendaraan) }}</span>
									</div>
								</td>
								<td class="fw-semibold">Rp {{ number_format($tarif->tarif_awal, 0, ',', '.') }}</td>
								<td class="fw-semibold">Rp {{ number_format($tarif->tarif_perjam, 0, ',', '.') }}</td>
								<td class="text-muted">{{ $tarif->keterangan ?: '-' }}</td>
							<td class="text-end">
									<a href="{{ route('admin.tarif.edit', $tarif) }}" class="btn btn-sm btn-light text-primary" title="Edit tarif" aria-label="Edit tarif {{ $tarif->jenis_kendaraan }}">
									<i class="bi bi-pencil"></i>
								</a>
								<form action="{{ route('admin.tarif.destroy', $tarif) }}" method="POST" class="d-inline">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus tarif" aria-label="Hapus tarif {{ $tarif->jenis_kendaraan }}" onclick="return confirm('Hapus tarif ini?')">
										<i class="bi bi-trash"></i>
									</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="text-center text-muted py-5">
								<i class="bi bi-receipt fs-2 d-block mb-2 text-primary"></i>
								Belum ada data tarif.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
			@if ($tarifs->hasPages())
				<div class="mt-4">{{ $tarifs->links() }}</div>
			@endif
		</div>
	</div>
@endsection
