@extends('layout.layout')

@section('title', 'Edit Kendaraan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Kendaraan</h4>
        <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.kendaraan.update', $kendaraan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="plat_nomor" class="form-label">Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror" value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" required>
                        @error('plat_nomor')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror" required>
                            <option value="">Pilih jenis</option>
                            <option value="motor" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="bis" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'bis' ? 'selected' : '' }}>Bis</option>
                            <option value="truk" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'truk' ? 'selected' : '' }}>Truk</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}">
                        @error('nama_pemilik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="area_id" class="form-label">Area Parkir</label>
                        <select name="area_id" id="area_id" class="form-select @error('area_id') is-invalid @enderror">
                            <option value="">-- Pilih area --</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id', $kendaraan->area_id) == $area->id ? 'selected' : '' }}>
                                    {{ $area->nama_area }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Perbarui Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
