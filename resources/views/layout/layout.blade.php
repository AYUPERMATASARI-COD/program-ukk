<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Parkir')</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #1e293b;
            position: fixed;
            top: 0;
            left: 0;
            transition: margin-left .3s ease;
            z-index: 1030;
        }
        #sidebar .brand {
            min-height: 73px;
            padding: .9rem 1rem;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex;
            align-items: center;
            gap: .7rem;
        }
        #sidebar .brand-mark {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, .35);
        }
        #sidebar .brand-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        #sidebar .brand-title {
            font-size: 1rem;
            letter-spacing: .01em;
        }
        #sidebar .brand-subtitle {
            margin-top: .25rem;
            color: #94a3b8;
            font-size: .63rem;
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        #sidebar .nav-link {
            color: #cbd5e1;
            padding: .65rem 1rem;
            border-radius: 6px;
            margin: 2px 8px;
        }
        #sidebar .nav-link i { width: 22px; }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: #334155;
            color: #fff;
        }
        #sidebar.collapsed { margin-left: -250px; }

        /* ===== CONTENT ===== */
        #content {
            margin-left: 250px;
            transition: margin-left .3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #content.expanded { margin-left: 0; }

        /* ===== TOPBAR ===== */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .7rem 1.2rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        main { flex: 1; padding: 1.5rem; }

        /* ===== FOOTER ===== */
        footer {
            background: #fff;
            border-top: 1px solid #e2e8f0;
            padding: .8rem 1.2rem;
            font-size: .85rem;
            color: #64748b;
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: -250px; }
            #sidebar.show { margin-left: 0; }
            #content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <nav id="sidebar">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-p-square-fill"></i></span>
            <span class="brand-copy">
                <span class="brand-title">Sistem Parkir</span>
                <span class="brand-subtitle">Parkir Kabasa</span>
            </span>
        </div>

        <div class="nav flex-column mt-2">
            @php
                $role = auth()->check() ? auth()->user()->role : null;
            @endphp

            {{-- ===== MENU ADMIN ===== --}}
            @if ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Data User
                </a>
                <a href="{{ route('admin.tarif.index') }}" class="nav-link {{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> Data Tarif
                </a>
                <a href="{{ route('admin.area.index') }}" class="nav-link {{ request()->routeIs('admin.area.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i> Area Parkir
                </a>
                <a href="{{ route('admin.kendaraan.index') }}" class="nav-link {{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front-fill"></i> Data Kendaraan
                </a>
                <a href="{{ route('admin.log.index') }}" class="nav-link {{ request()->routeIs('admin.log.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Log Aktivitas
                </a>

            {{-- ===== MENU PETUGAS ===== --}}
            @elseif ($role === 'petugas')
                <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('petugas.transaksi.masuk') }}" class="nav-link {{ request()->routeIs('petugas.transaksi.masuk') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-right"></i> Kendaraan Masuk
                </a>
                <a href="{{ route('petugas.transaksi.keluar') }}" class="nav-link {{ request()->routeIs('petugas.transaksi.keluar') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-right"></i> Transaksi Keluar
                </a>

            {{-- ===== MENU OWNER ===== --}}
            @elseif ($role === 'owner')
                <a href="{{ route('owner.dashboard') }}" class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('owner.laporan.index') }}" class="nav-link {{ request()->routeIs('owner.laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
                </a>
            @endif
        </div>
    </nav>

    <!-- ===== CONTENT WRAPPER ===== -->
    <div id="content">

        <!-- ===== TOPBAR ===== -->
        <div id="topbar" class="d-flex align-items-center justify-content-between">
            <button id="btnToggleSidebar" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-list"></i>
            </button>

            <div class="dropdown">
                <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span>{{ auth()->check() ? auth()->user()->name : 'Tamu' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">Role: {{ ucfirst($role ?? '-') }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ===== ALERT SESSION ===== -->
        <main>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- ===== FOOTER ===== -->
        <footer class="text-center">
            &copy; {{ date('Y') }} PARKIR-KABASA
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar   = document.getElementById('sidebar');
        const content   = document.getElementById('content');
        const btnToggle = document.getElementById('btnToggleSidebar');

        btnToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>