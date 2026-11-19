@extends('layout.layout')

@section('title', 'Kendaraan Masuk')

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
	</style>
@endpush

@section('content')
	<div class="transaksi-hero p-4 p-lg-5 mb-4">
		<div class="position-relative d-flex align-items-center gap-3" style="z-index: 1;">
			<span class="transaksi-icon"><i class="bi bi-box-arrow-in-right"></i></span>
			<div><div class="small text-white-50 text-uppercase fw-semibold mb-2">Operasional parkir</div><h1 class="h3 fw-bold mb-2">Kendaraan Masuk</h1><p class="mb-0 text-white-50">Catat kendaraan yang masuk ke area parkir.</p></div>
		</div>
	</div>
	<div class="card transaksi-card" style="max-width: 720px;"><div class="card-body p-4 p-lg-5">
		<div class="d-flex align-items-center gap-3 mb-4"><span class="transaksi-icon"><i class="bi bi-car-front-fill"></i></span><div><h5 class="mb-1">Form kendaraan masuk</h5><p class="text-muted small mb-0">Lengkapi data kendaraan sebelum menyimpan transaksi.</p></div></div>
		<form method="POST" action="{{ route('petugas.transaksi.masuk.store') }}">@csrf
			<div class="mb-3"><label class="form-label fw-semibold">Plat nomor</label><input name="plat_nomor" value="{{ old('plat_nomor') }}" class="form-control" placeholder="B 1234 ABC" required></div>
			<div class="mb-3"><label class="form-label fw-semibold">Jenis kendaraan</label><select name="jenis_kendaraan" class="form-select" required><option value="">Pilih jenis</option>@foreach (['motor' => 'Motor', 'mobil' => 'Mobil', 'bis' => 'Bis', 'truk' => 'Truk'] as $jenis => $label)<option value="{{ $jenis }}" @selected(old('jenis_kendaraan') === $jenis)>{{ $label }} - {{ $tarifs->has($jenis) ? 'Rp '.number_format($tarifs->get($jenis)->tarif_perjam, 0, ',', '.').'/jam' : 'Tarif belum diatur' }}</option>@endforeach</select></div>
			<div class="mb-3"><label class="form-label fw-semibold">Warna kendaraan</label><input name="warna" value="{{ old('warna') }}" class="form-control" placeholder="Contoh: Hitam" maxlength="50" required>@error('warna')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
			<div class="mb-3"><label class="form-label fw-semibold">Area parkir</label><select name="area_id" class="form-select" required><option value="">Pilih area parkir</option>@foreach ($areas as $area)@php($sisaKapasitas = $kapasitasTersedia->get($area->id))<option value="{{ $area->id }}" @selected((string) old('area_id') === (string) $area->id) @disabled($sisaKapasitas === 0)>{{ $area->nama_area }} (Sisa {{ $sisaKapasitas }}/{{ $area->kapasitas }})</option>@endforeach</select>@error('area_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
			<div class="mb-4"><label class="form-label fw-semibold">Nama pemilik <span class="text-muted fw-normal">(opsional)</span></label><input name="nama_pemilik" value="{{ old('nama_pemilik') }}" class="form-control"></div>
			<button class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i> Simpan kendaraan masuk</button>
		</form>
	</div></div>
@endsection
