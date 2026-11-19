<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $transaksi->status === 'masuk' ? 'Tiket Masuk' : 'Struk Keluar' }} #{{ $transaksi->id }} - {{ $transaksi->kendaraan?->plat_nomor }}</title>
	<style>
		:root {
			color-scheme: light;
			font-family: Arial, Helvetica, sans-serif;
			color: #18333a;
			background: #edf2f1;
		}
		* { box-sizing: border-box; }
		body { margin: 0; padding: 32px 16px; }
		.ticket {
			width: min(440px, 100%);
			margin: 0 auto;
			padding: 24px;
			background: #fff;
			border: 1px solid #d7e1de;
			border-radius: 10px;
			box-shadow: 0 12px 32px rgba(24, 51, 58, .1);
		}
		.ticket-header { display: flex; align-items: center; gap: 11px; }
		.brand-mark {
			width: 38px;
			height: 38px;
			display: grid;
			place-items: center;
			flex: 0 0 auto;
			border-radius: 8px;
			background: #14584e;
			color: #fff;
			font-size: 18px;
			font-weight: 700;
		}
		.brand-name { margin: 0; color: #18333a; font-size: 16px; font-weight: 700; }
		.brand-caption { margin: 3px 0 0; color: #718481; font-size: 11px; }
		.status {
			margin-left: auto;
			padding: 6px 9px;
			border-radius: 20px;
			font-size: 10px;
			font-weight: 700;
			text-transform: uppercase;
		}
		.status--entry { background: #e5f4ee; color: #176448; }
		.status--exit { background: #fff1d9; color: #87520b; }
		.ticket-id {
			margin: 22px 0 16px;
			padding: 15px 16px;
			border: 1px dashed #9ebbb1;
			border-radius: 8px;
			background: #f4f8f6;
		}
		.eyebrow { color: #718481; font-size: 10px; font-weight: 700; text-transform: uppercase; }
		.id-value { display: block; margin-top: 4px; color: #14584e; font-size: 28px; font-weight: 800; }
		.ticket-description { margin: 4px 0 0; color: #718481; font-size: 12px; }
		.plate-block { margin-bottom: 18px; padding: 12px 14px; border-left: 3px solid #d69b35; background: #fff8e9; }
		.plate-label { display: block; color: #83714c; font-size: 10px; font-weight: 700; text-transform: uppercase; }
		.plate-value { display: block; margin-top: 3px; color: #18333a; font-size: 21px; font-weight: 800; }
		.section-title { margin: 18px 0 7px; color: #718481; font-size: 10px; font-weight: 700; text-transform: uppercase; }
		.details { margin: 0; }
		.detail-row { display: flex; justify-content: space-between; gap: 16px; padding: 7px 0; border-bottom: 1px solid #edf1ef; font-size: 12px; }
		.detail-row dt { color: #718481; }
		.detail-row dd { margin: 0; color: #18333a; text-align: right; font-weight: 600; }
		.notice { margin-top: 16px; padding: 10px 12px; border-radius: 6px; background: #eaf5f0; color: #24594b; font-size: 11px; line-height: 1.5; }
		.payment { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; margin-top: 18px; padding-top: 14px; border-top: 2px solid #18333a; }
		.payment-label { color: #526a67; font-size: 12px; font-weight: 700; }
		.payment-value { color: #14584e; font-size: 22px; font-weight: 800; }
		.ticket-footer { margin-top: 18px; padding-top: 12px; border-top: 1px dashed #c8d5d1; color: #718481; font-size: 10px; line-height: 1.6; }
		.actions { display: flex; justify-content: center; gap: 9px; margin: 16px auto 0; }
		button, .back-link { min-height: 40px; padding: 0 16px; border: 0; border-radius: 6px; cursor: pointer; font: inherit; font-size: 13px; text-decoration: none; }
		button { background: #14584e; color: #fff; font-weight: 700; }
		.back-link { display: inline-flex; align-items: center; background: #e1e9e6; color: #294740; }
		@media (max-width: 480px) {
			body { padding: 16px 10px; }
			.ticket { padding: 19px; }
		}
		@media print {
			@page { size: 80mm auto; margin: 3mm; }
			:root, body { background: #fff; }
			body { padding: 0; }
			.ticket { width: 100%; max-width: none; padding: 3mm; border: 0; border-radius: 0; box-shadow: none; }
			.actions { display: none; }
			.ticket, .ticket * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
		}
	</style>
</head>
<body>
	<main class="ticket">
		<header class="ticket-header">
			<span class="brand-mark" aria-hidden="true">P</span>
			<div>
				<p class="brand-name">Sistem Parkir Kabasa</p>
				<p class="brand-caption">Bukti transaksi parkir</p>
			</div>
			<span class="status {{ $transaksi->status === 'masuk' ? 'status--entry' : 'status--exit' }}">
				{{ $transaksi->status === 'masuk' ? 'Kendaraan masuk' : 'Kendaraan keluar' }}
			</span>
		</header>

		<section class="ticket-id" aria-label="ID tiket">
			<span class="eyebrow">ID transaksi</span>
			<strong class="id-value">#{{ $transaksi->id }}</strong>
			<p class="ticket-description">{{ $transaksi->status === 'masuk' ? 'Tiket masuk kendaraan' : 'Bukti pembayaran kendaraan keluar' }}</p>
		</section>

		<div class="plate-block">
			<span class="plate-label">Plat nomor</span>
			<strong class="plate-value">{{ $transaksi->kendaraan?->plat_nomor ?: '-' }}</strong>
		</div>

		<p class="section-title">Informasi kendaraan</p>
		<dl class="details">
			<div class="detail-row"><dt>Jenis kendaraan</dt><dd>{{ ucfirst($transaksi->kendaraan?->jenis_kendaraan ?: '-') }}</dd></div>
			<div class="detail-row"><dt>Warna</dt><dd>{{ $transaksi->kendaraan?->warna ?: '-' }}</dd></div>
			@if ($transaksi->kendaraan?->nama_pemilik)
				<div class="detail-row"><dt>Pemilik</dt><dd>{{ $transaksi->kendaraan->nama_pemilik }}</dd></div>
			@endif
			@if ($transaksi->status === 'masuk')
				<div class="detail-row"><dt>Area parkir</dt><dd>{{ $transaksi->kendaraan?->area?->nama_area ?: '-' }}</dd></div>
			@endif
		</dl>

		<p class="section-title">Waktu transaksi</p>
		<dl class="details">
			<div class="detail-row"><dt>Waktu masuk</dt><dd>{{ $transaksi->waktu_masuk?->format('d/m/Y H:i') ?: '-' }}</dd></div>
			@if ($transaksi->status === 'masuk')
				<div class="detail-row"><dt>Tarif per jam</dt><dd>{{ $tarif ? 'Rp '.number_format($tarif->tarif_perjam, 0, ',', '.') : 'Belum diatur' }}</dd></div>
			@else
				<div class="detail-row"><dt>Waktu keluar</dt><dd>{{ $transaksi->waktu_keluar?->format('d/m/Y H:i') ?: '-' }}</dd></div>
			@endif
		</dl>

		@if ($transaksi->status === 'masuk')
			<div class="notice">Simpan dan tunjukkan tiket ini kepada petugas untuk masuk ke area parkir. Gunakan ID tiket yang sama saat kendaraan keluar.</div>
		@else
			<div class="payment"><span class="payment-label">Total pembayaran</span><strong class="payment-value">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</strong></div>
		@endif

		<footer class="ticket-footer">
			<div>Petugas: {{ $transaksi->user?->name ?: '-' }}</div>
			<div>Parkir Kabasa | ID #{{ $transaksi->id }}</div>
		</footer>
	</main>

	<div class="actions">
		<button type="button" onclick="window.print()">{{ $transaksi->status === 'masuk' ? 'Cetak tiket' : 'Cetak struk' }}</button>
		<a class="back-link" href="{{ route($transaksi->status === 'masuk' ? 'petugas.transaksi.masuk' : 'petugas.transaksi.keluar') }}">Kembali</a>
	</div>
</body>
</html>
