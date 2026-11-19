@extends('layout.layout')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit User</h4>
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

            <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="form-control" placeholder="Masukkan nama lengkap" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                           class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    <small class="text-muted">Biarkan kosong kalau tidak ingin ganti password.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="owner" {{ old('role', $user->role) === 'owner' ? 'selected' : '' }}>Owner</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-save"></i> Update
                </button>
            </form>

        </div>
    </div>
@endsection