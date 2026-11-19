@extends('layout.layout')

@section('title', 'Edit Tarif')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Tarif</h4>
        <a href="{{ route('admin.tarif.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.tarif.update', $tarif) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror" required>
                            <option value="">Pilih jenis kendaraan</option>
                            <option value="motor" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) === 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) === 'mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="bis" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) === 'bis' ? 'selected' : '' }}>Bis</option>
                            <option value="truk" {{ old('jenis_kendaraan', $tarif->jenis_kendaraan) === 'truk' ? 'selected' : '' }}>Truk</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $tarif->keterangan) }}" placeholder="Contoh: Tarif standar truk">
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tarif_awal" class="form-label">Tarif Awal</label>
                        <input type="number" name="tarif_awal" id="tarif_awal" min="0" step="100" class="form-control @error('tarif_awal') is-invalid @enderror" value="{{ old('tarif_awal', $tarif->tarif_awal) }}" required>
                        @error('tarif_awal')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tarif_perjam" class="form-label">Tarif Per Jam</label>
                        <input type="number" name="tarif_perjam" id="tarif_perjam" min="0" step="100" class="form-control @error('tarif_perjam') is-invalid @enderror" value="{{ old('tarif_perjam', $tarif->tarif_perjam) }}" required>
                        @error('tarif_perjam')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Perbarui Tarif</button>
                </div>
            </form>
        </div>
    </div>
@endsection
