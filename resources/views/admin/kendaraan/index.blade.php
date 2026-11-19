@extends('layout.layout')

@section('title', 'Data Kendaraan')

@push('styles')
	<style>
		.kendaraan-hero { background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%); color: #fff; border-radius: 14px; overflow: hidden; position: relative; }
		.kendaraan-hero::after { content: ''; width: 220px; height: 220px; border: 28px solid rgba(255,255,255,.09); border-radius: 50%; position: absolute; right: -70px; top: -100px; }
		.admin-data-card { border: 0; border-radius: 12px; box-shadow: 0 5px 18px rgba(15, 23, 42, .08); }
		.admin-data-table thead th { color: #64748b; font-size: .75rem; letter-spacing: .04em; text-transform: uppercase; border-bottom-width: 1px; }
		.admin-data-table tbody tr:last-child td { border-bottom: 0; }
		.admin-data-table tbody tr { transition: background-color .2s ease; }
		.admin-data-table tbody tr:hover { background-color: #f8fafc; }
		.data-icon { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 11px; background: #dbeafe; color: #1d4ed8; }
	</style>
@endpush

@section('content')
	<div class="kendaraan-hero p-4 p-lg-5 mb-4"><div class="position-relative" style="z-index: 1;"><div class="small text-white-50 text-uppercase fw-semibold mb-2">Data kendaraan</div><h1 class="h3 fw-bold mb-2">Data Kendaraan</h1><p class="mb-0 text-white-50">Pantau kendaraan yang terdaftar di area parkir.</p></div></div>

	<div class="card admin-data-card"><div class="card-body p-3 p-lg-4">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4"><div><h5 class="mb-1">Daftar kendaraan</h5><p class="text-muted small mb-0">{{ $kendaraans->total() }} kendaraan terdaftar dalam sistem</p></div>
		<form method="GET" class="m-0"><div class="input-group" style="max-width: 360px;"><span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span><input type="search" id="vehicleSearchInput" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari plat nomor atau pemilik" aria-label="Cari plat nomor atau pemilik"><button type="submit" class="btn btn-primary">Cari</button></div></form></div>
		<div class="table-responsive"><table class="table admin-data-table align-middle mb-0">
				<thead>
					<tr>
						<th>Plat Nomor</th>
						<th>Jenis</th>
						<th>Pemilik</th>
						<th>Area Parkir</th>
						<th class="text-end">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($kendaraans as $kendaraan)
						<tr data-vehicle-row>
							<td><div class="d-flex align-items-center gap-3"><span class="data-icon"><i class="bi bi-car-front-fill"></i></span><span class="fw-bold text-dark">{{ $kendaraan->plat_nomor }}</span></div></td>
							<td><span class="badge rounded-pill bg-primary-subtle text-primary">{{ ucfirst($kendaraan->jenis_kendaraan) }}</span></td>
							<td class="text-muted">{{ $kendaraan->nama_pemilik ?: '-' }}</td>
							<td class="text-muted">{{ $kendaraan->area?->nama_area ?: '-' }}</td>
							<td class="text-end">
								<a href="{{ route('admin.kendaraan.edit', $kendaraan) }}" class="btn btn-sm btn-light text-primary" title="Edit kendaraan" aria-label="Edit kendaraan {{ $kendaraan->plat_nomor }}"><i class="bi bi-pencil"></i></a>
								<form action="{{ route('admin.kendaraan.destroy', $kendaraan) }}" method="POST" class="d-inline">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus kendaraan" aria-label="Hapus kendaraan {{ $kendaraan->plat_nomor }}" onclick="return confirm('Hapus kendaraan ini?')"><i class="bi bi-trash"></i></button>
								</form>
							</td>
						</tr>
					@empty
						<tr><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-car-front fs-2 d-block mb-2 text-primary"></i>Belum ada data kendaraan.</td></tr>
					@endforelse
					<tr id="noVehicleMatchRow" style="display: none;"><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-search fs-2 d-block mb-2 text-primary"></i>Kendaraan tidak ditemukan.</td></tr>
				</tbody>
			</table>
		</div>
		@if ($kendaraans->hasPages())<div class="mt-4">{{ $kendaraans->links() }}</div>@endif
	</div></div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const searchInput = document.getElementById('vehicleSearchInput');
			const tableBody = document.querySelector('.admin-data-table tbody');
			const rows = Array.from(document.querySelectorAll('[data-vehicle-row]'));
			const emptyRow = document.getElementById('noVehicleMatchRow');

			if (!searchInput || !tableBody || rows.length === 0) {
				return;
			}

			const applyFilter = () => {
				const query = searchInput.value.trim().toLowerCase();
				const matchedRows = [];
				const otherRows = [];

				rows.forEach((row) => {
					const isMatch = !query || row.textContent.toLowerCase().includes(query);
					row.style.display = isMatch ? '' : 'none';
					(isMatch ? matchedRows : otherRows).push(row);
				});

				[...matchedRows, ...otherRows].forEach((row) => tableBody.appendChild(row));
				if (emptyRow) {
					emptyRow.style.display = matchedRows.length === 0 ? '' : 'none';
				}
			};

			searchInput.addEventListener('input', applyFilter);
			searchInput.addEventListener('search', applyFilter);
			applyFilter();
		});
	</script>
@endpush
