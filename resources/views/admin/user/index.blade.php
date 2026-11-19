@extends('layout.layout')

@section('title', 'Data User')

@push('styles')
    <style>
        .user-hero {
            background: linear-gradient(135deg, #172554 0%, #1d4ed8 62%, #0f766e 100%);
            color: #fff;
            border-radius: 14px;
            overflow: hidden;
            position: relative;
        }
        .user-hero::after {
            content: '';
            width: 220px;
            height: 220px;
            border: 28px solid rgba(255,255,255,.09);
            border-radius: 50%;
            position: absolute;
            right: -70px;
            top: -100px;
        }
        .user-table-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .08);
        }
        .user-avatar {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
        }
        .user-table thead th {
            color: #64748b;
            font-size: .75rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            border-bottom-width: 1px;
        }
        .user-table tbody tr:last-child td { border-bottom: 0; }
        .user-table tbody tr { transition: background-color .2s ease; }
        .user-table tbody tr:hover { background-color: #f8fafc; }
        .role-badge { padding: .45em .75em; font-weight: 600; }
    </style>
@endpush

@section('content')
    <div class="user-hero p-4 p-lg-5 mb-4">
        <div class="position-relative d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="z-index: 1;">
            <div>
                <div class="small text-white-50 text-uppercase fw-semibold mb-2">Manajemen akses</div>
                <h1 class="h3 fw-bold mb-2">Data User</h1>
                <p class="mb-0 text-white-50">Kelola akun dan hak akses pengguna sistem parkir.</p>
            </div>
            <a href="{{ route('admin.user.create') }}" class="btn btn-light text-primary fw-semibold">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="card user-table-card">
        <div class="card-body p-3 p-lg-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h5 class="mb-1">Daftar pengguna</h5>
                    <p class="text-muted small mb-0">{{ $users->total() }} akun terdaftar dalam sistem</p>
                </div>
                <form method="GET" action="{{ route('admin.user.index') }}" class="m-0">
                    <div class="input-group" style="max-width: 320px;">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="search" id="userSearchInput" name="search" value="{{ request('search') }}"
                               class="form-control border-start-0 ps-0" placeholder="Cari nama / username..." aria-label="Cari nama atau username">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table user-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @forelse ($users as $user)
                            <tr data-user-row>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email ?? 'Pengguna sistem' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ '@' . $user->username }}</td>
                                <td>
                                    @php
                                        $badgeColor = match($user->role) {
                                            'admin'   => 'danger',
                                            'petugas' => 'primary',
                                            'owner'   => 'success',
                                            default   => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge rounded-pill role-badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.user.edit', $user->id) }}"
                                           class="btn btn-sm btn-light text-primary" title="Edit user" aria-label="Edit user {{ $user->name }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}"
                                              onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus user" aria-label="Hapus user {{ $user->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noUserRow">
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-2 d-block mb-2 text-primary"></i>
                                    Belum ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('userSearchInput');
            const rows = Array.from(document.querySelectorAll('[data-user-row]'));
            const emptyRow = document.getElementById('noUserRow');

            if (!searchInput || rows.length === 0) {
                return;
            }

            const applyFilter = () => {
                const query = searchInput.value.trim().toLowerCase();
                let visibleCount = 0;

                rows.forEach((row) => {
                    const text = row.textContent.toLowerCase();
                    const match = !query || text.includes(query);
                    row.style.display = match ? '' : 'none';
                    if (match) {
                        visibleCount++;
                    }
                });

                if (emptyRow) {
                    emptyRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            };

            searchInput.addEventListener('input', applyFilter);
            searchInput.addEventListener('search', applyFilter);
            applyFilter();
        });
    </script>
@endsection