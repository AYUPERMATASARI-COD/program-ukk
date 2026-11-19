@extends('layout.layout')

@section('title', 'Log Aktivitas')

@push('styles')
	<style>
		.log-hero { background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%); color: #fff; border-radius: 14px; overflow: hidden; position: relative; }
		.log-hero::after { content: ''; width: 220px; height: 220px; border: 28px solid rgba(255,255,255,.09); border-radius: 50%; position: absolute; right: -70px; top: -100px; }
		.admin-data-card { border: 0; border-radius: 12px; box-shadow: 0 5px 18px rgba(15, 23, 42, .08); }
		.admin-data-table thead th { color: #64748b; font-size: .75rem; letter-spacing: .04em; text-transform: uppercase; border-bottom-width: 1px; }
		.admin-data-table tbody tr:last-child td { border-bottom: 0; }
		.admin-data-table tbody tr { transition: background-color .2s ease; }
		.admin-data-table tbody tr:hover { background-color: #f8fafc; }
	</style>
@endpush

@section('content')
	<div class="log-hero p-4 p-lg-5 mb-4"><div class="position-relative" style="z-index: 1;"><div class="small text-white-50 text-uppercase fw-semibold mb-2">Riwayat sistem</div><h1 class="h3 fw-bold mb-2">Log Aktivitas</h1><p class="mb-0 text-white-50">Pantau seluruh aktivitas pengguna dalam sistem parkir.</p></div></div>

	<div class="card admin-data-card"><div class="card-body p-3 p-lg-4">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4"><div><h5 class="mb-1">Riwayat aktivitas</h5><p class="text-muted small mb-0">{{ $logs->total() }} aktivitas tercatat dalam sistem</p></div>
		<form method="GET" class="m-0"><div class="row g-2"><div class="col-md-auto"><div class="input-group"><span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span><input type="search" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari aktivitas atau keterangan"></div></div><div class="col-md-auto"><input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control"></div><div class="col-auto"><button type="submit" class="btn btn-primary">Cari</button></div></div></form></div>
		<div class="table-responsive"><table class="table admin-data-table align-middle mb-0">
				<thead>
					<tr>
						<th>Waktu</th>
						<th>User</th>
						<th>Aktivitas</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($logs as $log)
						<tr>
							<td class="text-muted"><i class="bi bi-clock me-1"></i>{{ $log->created_at?->format('d/m/Y H:i') }}</td>
							<td class="fw-semibold text-dark">{{ $log->user?->name ?: '-' }}</td>
							<td><span class="badge rounded-pill bg-primary-subtle text-primary">{{ $log->aktivitas }}</span></td>
							<td class="text-muted">{{ $log->keterangan ?: '-' }}</td>
						</tr>
					@empty
						<tr><td colspan="4" class="text-center text-muted py-5"><i class="bi bi-clock-history fs-2 d-block mb-2 text-primary"></i>Belum ada log aktivitas.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
		@if ($logs->hasPages())<div class="mt-4">{{ $logs->links('pagination::bootstrap-5') }}</div>@endif
	</div></div>
	</div>
@endsection
