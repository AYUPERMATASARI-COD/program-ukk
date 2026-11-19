@extends('layout.layout')

@section('title', 'Tambah User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Tambah User</h4>
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-control" placeholder="Masukkan nama lengkap" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                           class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Role --</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </form>

        </div>
    </div>
@endsection