@extends('layout.layout')

@section('title', 'Area Parkir')

@push('styles')
	<style>
		.area-hero, .kendaraan-hero, .log-hero {
			background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%);
			color: #fff;
			border-radius: 14px;
			overflow: hidden;
			position: relative;
		}
		.area-hero::after, .kendaraan-hero::after, .log-hero::after {
			content: '';
			width: 220px;
			height: 220px;
			border: 28px solid rgba(255,255,255,.09);
			border-radius: 50%;
			position: absolute;
			right: -70px;
			top: -100px;
		}
		.admin-data-card {
			border: 0;
			border-radius: 12px;
			box-shadow: 0 5px 18px rgba(15, 23, 42, .08);
		}
		.admin-data-table thead th {
			color: #64748b;
			font-size: .75rem;
			letter-spacing: .04em;
			text-transform: uppercase;
			border-bottom-width: 1px;
		}
		.admin-data-table tbody tr:last-child td { border-bottom: 0; }
		.admin-data-table tbody tr { transition: background-color .2s ease; }
		.admin-data-table tbody tr:hover { background-color: #f8fafc; }
		.data-icon {
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
	<div class="area-hero p-4 p-lg-5 mb-4">
		<div class="position-relative d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="z-index: 1;">
			<div><div class="small text-white-50 text-uppercase fw-semibold mb-2">Manajemen lokasi</div><h1 class="h3 fw-bold mb-2">Area Parkir</h1><p class="mb-0 text-white-50">Kelola lokasi dan kapasitas parkir yang tersedia.</p></div>
			<a href="{{ route('admin.area.create') }}" class="btn btn-light text-primary fw-semibold"><i class="bi bi-plus-lg me-1"></i> Tambah Area</a>
		</div>
	</div>

	<div class="card admin-data-card"><div class="card-body p-3 p-lg-4">
		<div class="mb-4"><h5 class="mb-1">Daftar area parkir</h5><p class="text-muted small mb-0">{{ $areas->total() }} lokasi terdaftar dalam sistem</p></div>
		<div class="table-responsive"><table class="table admin-data-table align-middle mb-0">
				<thead>
					<tr>
						<th>Nama Area</th>
						<th>Kapasitas</th>
						<th>Keterangan</th>
						<th class="text-end">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($areas as $area)
						<tr>
							<td><div class="d-flex align-items-center gap-3"><span class="data-icon"><i class="bi bi-geo-alt-fill"></i></span><span class="fw-semibold text-dark">{{ $area->nama_area }}</span></div></td>
							<td><span class="badge rounded-pill bg-success-subtle text-success">{{ $area->kapasitas }} kendaraan</span></td>
							<td class="text-muted">{{ $area->keterangan ?: '-' }}</td>
							<td class="text-end">
								<a href="{{ route('admin.area.edit', $area) }}" class="btn btn-sm btn-light text-primary" title="Edit area" aria-label="Edit area {{ $area->nama_area }}">
									<i class="bi bi-pencil"></i>
								</a>
								<form action="{{ route('admin.area.destroy', $area) }}" method="POST" class="d-inline">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus area" aria-label="Hapus area {{ $area->nama_area }}" onclick="return confirm('Hapus area ini?')">
										<i class="bi bi-trash"></i>
									</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center text-muted py-5"><i class="bi bi-geo-alt fs-2 d-block mb-2 text-primary"></i>Belum ada data area parkir.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		@if ($areas->hasPages())<div class="mt-4">{{ $areas->links() }}</div>@endif
	</div></div>
	</div>
@endsection
