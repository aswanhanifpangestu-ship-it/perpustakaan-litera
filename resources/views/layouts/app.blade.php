<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Litera') — Litera 📚</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-w   : 265px;
            --primary     : #0d9488;   /* teal-600  */
            --primary-dark: #0f766e;   /* teal-700  */
            --primary-xd  : #134e4a;   /* teal-900  */
            --accent      : #f59e0b;   /* amber-400 */
            --accent-dark : #d97706;   /* amber-500 */
            --bg          : #f0fdf9;   /* teal-50   */
            --surface     : #ffffff;
            --border      : #ccfbf1;   /* teal-100  */
            --text        : #134e4a;
            --muted       : #5eead4;   /* teal-300  */
        }

        * { box-sizing: border-box; }
        body {
            background: var(--bg);
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            color: var(--text);
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #99f6e4; border-radius: 99px; }

        /* ══════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════ */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(160deg, var(--primary-xd) 0%, var(--primary-dark) 60%, var(--primary) 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: transform .3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Brand */
        .sidebar-brand {
            padding: 1.4rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .sidebar-brand .brand-logo {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: .6rem;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: .5rem;
        }
        .sidebar-brand h5 {
            color: #fff; font-weight: 800; margin: 0; font-size: 1.05rem; letter-spacing: .3px;
        }
        .sidebar-brand small {
            color: rgba(255,255,255,.5);
            font-size: .62rem; line-height: 1.5; display: block; margin-top: .25rem;
        }

        /* Nav */
        #sidebar .nav-scroll {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 10px;
        }
        #sidebar .nav-section {
            font-size: .65rem; font-weight: 700;
            color: rgba(255,255,255,.35);
            text-transform: uppercase; letter-spacing: .1em;
            padding: .9rem 1.25rem .2rem;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,.72);
            padding: .55rem 1rem;
            border-radius: .5rem;
            margin: .08rem .75rem;
            transition: all .18s;
            font-size: .875rem;
            font-weight: 500;
            display: flex; align-items: center; gap: .6rem;
        }
        #sidebar .nav-link i { font-size: 1rem; flex-shrink: 0; }
        #sidebar .nav-link:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
            transform: translateX(2px);
        }
        #sidebar .nav-link.active {
            background: var(--accent);
            color: #1c1917;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(245,158,11,.35);
        }
        #sidebar .nav-link.active i { color: #1c1917; }

        /* Bottom area */
        .sidebar-bottom {
            border-top: 1px solid rgba(255,255,255,.12);
            flex-shrink: 0;
        }
        .sidebar-user {
            display: flex; align-items: center; gap: .65rem;
            padding: .75rem 1rem;
        }
        .sidebar-user .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 700; color: #1c1917; flex-shrink: 0;
        }
        .sidebar-user .uname { color: #fff; font-size: .82rem; font-weight: 600; }
        .sidebar-user .urole { color: rgba(255,255,255,.5); font-size: .68rem; }

        /* ══════════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════════ */
        #main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            transition: margin .3s ease;
        }

        /* Topbar */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: .7rem 1.5rem;
            position: sticky; top: 0; z-index: 999;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar .page-title {
            font-size: .95rem; font-weight: 700; color: var(--text);
        }

        /* ══════════════════════════════════════════
           CARDS
        ══════════════════════════════════════════ */
        .card {
            border: 1px solid var(--border);
            border-radius: .875rem;
            box-shadow: 0 1px 4px rgba(13,148,136,.06);
        }
        .card-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            border-radius: .875rem .875rem 0 0 !important;
        }
        .card-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
        }
        .stat-card {
            border: 1px solid var(--border);
            border-radius: .875rem;
            box-shadow: 0 1px 4px rgba(13,148,136,.06);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(13,148,136,.12);
        }
        .stat-icon {
            width: 3rem; height: 3rem; border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem; flex-shrink: 0;
        }
        .table-card {
            border: 1px solid var(--border);
            border-radius: .875rem;
            box-shadow: 0 1px 4px rgba(13,148,136,.06);
            overflow: hidden;
        }

        /* ══════════════════════════════════════════
           TABLE
        ══════════════════════════════════════════ */
        .table thead th {
            background: #f0fdf9;
            font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
            color: var(--primary-dark);
            border-bottom: 2px solid var(--border);
            padding: .65rem .75rem;
        }
        .table tbody td { padding: .6rem .75rem; vertical-align: middle; }
        .table-hover tbody tr:hover { background: #f0fdf9; }

        /* ══════════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════════ */
        .btn-primary {
            background: var(--primary); border-color: var(--primary); color: #fff;
        }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
        .btn-xs { padding: .2rem .45rem; font-size: .75rem; }

        /* ══════════════════════════════════════════
           BADGES
        ══════════════════════════════════════════ */
        .badge-admin   { background: #fef3c7; color: #92400e; }
        .badge-petugas { background: #ccfbf1; color: #0f766e; }
        .badge-user    { background: #ede9fe; color: #5b21b6; }

        /* ══════════════════════════════════════════
           FORM CONTROLS
        ══════════════════════════════════════════ */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(13,148,136,.2);
        }

        /* ══════════════════════════════════════════
           ALERTS
        ══════════════════════════════════════════ */
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .alert-danger  { background: #fff1f2; border-color: #fecdd3; color: #9f1239; }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- ══ SIDEBAR ══ -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">📚</div>
        <h5>Litera</h5>
        <small>Sistem Perpustakaan Digital — kelola buku, peminjaman & laporan dengan mudah.</small>
    </div>

    <div class="nav-scroll">
        <ul class="nav flex-column mt-1">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> 🏠 Dashboard
                </a>
            </li>

            <div class="nav-section">📖 Koleksi</div>
            <li class="nav-item">
                <a href="{{ route('buku.index') }}"
                   class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i> 📗 Buku
                </a>
            </li>
            @if(auth()->user()->isAdminOrPetugas())
            <li class="nav-item">
                <a href="{{ route('kategori.index') }}"
                   class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> 🏷️ Kategori
                </a>
            </li>
            @endif

            <div class="nav-section">🔄 Sirkulasi</div>
            <li class="nav-item">
                <a href="{{ route('peminjaman.index') }}"
                   class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i> 📋 Peminjaman
                </a>
            </li>
            @if(auth()->user()->isUser())
            <li class="nav-item">
                <a href="{{ route('peminjaman.index', ['status_denda' => 'belum_bayar']) }}"
                   class="nav-link {{ request()->is('peminjaman') && request('status_denda') === 'belum_bayar' ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> 💸 Denda Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('struk.index') }}"
                   class="nav-link {{ request()->routeIs('struk.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> 🧾 Struk Saya
                </a>
            </li>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="nav-section">⚙️ Manajemen</div>
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> 👥 Pengguna
                </a>
            </li>
            @endif

            @if(auth()->user()->isPetugas())
            <div class="nav-section">⚙️ Manajemen</div>
            <li class="nav-item">
                <a href="{{ route('users.index', ['tab' => 'anggota']) }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> 👥 Anggota
                </a>
            </li>
            @endif

            @if(auth()->user()->isAdminOrPetugas())
            <div class="nav-section">📊 Laporan</div>
            <li class="nav-item">
                <a href="{{ route('laporan.index') }}"
                   class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i> 📈 Laporan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ulasan.index') }}"
                   class="nav-link {{ request()->routeIs('ulasan.index') ? 'active' : '' }}">
                    <i class="bi bi-star"></i> ⭐ Ulasan Buku
                </a>
            </li>
            @endif

            <div class="nav-section">👤 Akun</div>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}"
                   class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> 🪪 Profil Saya
                </a>
            </li>

        </ul>
    </div>

    <!-- Bottom: Notifikasi + User Info -->
    <div class="sidebar-bottom">
        @include('notifications._sidebar_bell')
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="overflow-hidden">
                <div class="uname text-truncate">{{ auth()->user()->name }}</div>
                <div class="urole">
                    @if(auth()->user()->isAdmin()) 👑 @elseif(auth()->user()->isPetugas()) 🛡️ @else 📖 @endif
                    {{ ucfirst(auth()->user()->role) }}
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- ══ MAIN CONTENT ══ -->
<div id="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill px-3 py-2
                @if(auth()->user()->isAdmin()) badge-admin
                @elseif(auth()->user()->isPetugas()) badge-petugas
                @else badge-user @endif">
                @if(auth()->user()->isAdmin()) 👑 @elseif(auth()->user()->isPetugas()) 🛡️ @else 📖 @endif
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Page Content -->
    <div class="p-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-3" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-3" role="alert">
            ❌ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => new bootstrap.Alert(el).close());
    }, 4500);
</script>
@stack('scripts')
</body>
</html>
