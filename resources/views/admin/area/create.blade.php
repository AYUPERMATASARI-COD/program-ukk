@extends('layout.layout')

@section('title', 'Tambah Area Parkir')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Tambah Area Parkir</h4>
        <a href="{{ route('admin.area.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.area.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_area" class="form-label">Nama Area</label>
                        <input type="text" name="nama_area" id="nama_area" class="form-control @error('nama_area') is-invalid @enderror" value="{{ old('nama_area') }}" required>
                        @error('nama_area')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="kapasitas" class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" id="kapasitas" min="1" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas') }}" required>
                        @error('kapasitas')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Area</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
