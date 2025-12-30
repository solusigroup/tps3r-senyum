<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - TPS3R Senyum</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --emerald-50: #ecfdf5;
            --emerald-100: #d1fae5;
            --emerald-200: #a7f3d0;
            --emerald-500: #10b981;
            --emerald-600: #059669;
            --emerald-700: #047857;
            --emerald-800: #065f46;
            --emerald-900: #064e3b;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--slate-50);
            color: var(--slate-900);
            min-height: 100vh;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--emerald-900) 0%, var(--emerald-800) 100%);
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo {
            background: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo i {
            color: var(--emerald-700);
            width: 24px;
            height: 24px;
        }

        .sidebar-title {
            color: white;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 1rem;
            margin-top: 1rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            color: var(--emerald-100);
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .nav-item:hover {
            background: var(--emerald-800);
        }

        .nav-item.active {
            background: var(--emerald-700);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-item i {
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--slate-800);
        }

        .page-subtitle {
            color: var(--slate-500);
            margin-top: 0.25rem;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 1rem;
            border: 1px solid var(--slate-100);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--slate-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-weight: 700;
            color: var(--slate-800);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid var(--slate-100);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--slate-800);
            margin-top: 0.25rem;
        }

        .stat-content p {
            font-size: 0.875rem;
            color: var(--slate-500);
        }

        .stat-content .stat-sub {
            font-size: 0.75rem;
            color: var(--slate-400);
            margin-top: 0.25rem;
        }

        .stat-icon {
            padding: 0.75rem;
            border-radius: 0.75rem;
        }

        .stat-icon.blue { background: #3b82f6; }
        .stat-icon.green { background: var(--emerald-500); }
        .stat-icon.orange { background: #f97316; }
        .stat-icon.purple { background: #8b5cf6; }

        .stat-icon i {
            color: white;
            width: 24px;
            height: 24px;
        }

        /* Grid */
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .col-span-2 { grid-column: span 2; }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }

        .table thead {
            background: var(--slate-50);
        }

        .table th {
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: var(--slate-500);
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .table td {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--slate-100);
        }

        .table tbody tr:hover {
            background: var(--slate-50);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--emerald-600);
            color: white;
        }

        .btn-primary:hover {
            background: var(--emerald-700);
        }

        .btn-secondary {
            background: white;
            color: var(--slate-700);
            border: 1px solid var(--slate-200);
        }

        .btn-secondary:hover {
            background: var(--slate-50);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--slate-600);
            margin-bottom: 0.375rem;
        }

        .form-control {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid var(--slate-200);
            border-radius: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--emerald-500);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-success {
            background: var(--emerald-100);
            color: var(--emerald-700);
        }

        .badge-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-info {
            background: #dbeafe;
            color: #2563eb;
        }

        /* Alert */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: var(--emerald-50);
            color: var(--emerald-800);
            border: 1px solid var(--emerald-200);
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Schedule Item */
        .schedule-item {
            display: flex;
            gap: 1rem;
            padding: 0.75rem;
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .schedule-item.active {
            background: var(--emerald-50);
            border: 1px solid var(--emerald-100);
        }

        .schedule-time {
            background: var(--emerald-600);
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .schedule-info h5 {
            font-weight: 700;
            font-size: 0.875rem;
            color: var(--slate-800);
        }

        .schedule-info p {
            font-size: 0.75rem;
            color: var(--slate-500);
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.25rem;
            margin-top: 1rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            text-decoration: none;
            color: var(--slate-600);
        }

        .pagination a:hover {
            background: var(--slate-100);
        }

        .pagination .active span {
            background: var(--emerald-600);
            color: white;
        }

        /* Responsive */
        @media (max-width: 1280px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 1024px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
            .col-span-2 { grid-column: span 1; }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .grid-4, .grid-3, .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .sidebar, .no-print, .btn, form:not(.print-include) {
                display: none !important;
            }
            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .app-container {
                display: block !important;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
            .stat-card {
                border: 1px solid #ddd !important;
            }
            .page-header {
                margin-bottom: 1rem !important;
            }
            .badge {
                border: 1px solid currentColor !important;
            }
            @page {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i data-lucide="recycle"></i>
                </div>
                <span class="sidebar-title">TPS3R Senyum</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('pengangkutan.index') }}" class="nav-item {{ request()->routeIs('pengangkutan.*') ? 'active' : '' }}">
                    <i data-lucide="truck"></i>
                    <span>Pengangkutan</span>
                </a>
                <a href="{{ route('pemilahan.index') }}" class="nav-item {{ request()->routeIs('pemilahan.*') ? 'active' : '' }}">
                    <i data-lucide="recycle"></i>
                    <span>Pemilahan</span>
                </a>
                <a href="{{ route('penjualan.index') }}" class="nav-item {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
                    <i data-lucide="banknote"></i>
                    <span>Penjualan</span>
                </a>
                <a href="{{ route('iuran.index') }}" class="nav-item {{ request()->routeIs('iuran.*') ? 'active' : '' }}">
                    <i data-lucide="wallet"></i>
                    <span>Iuran Warga</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i>
                    <span>Pelanggan</span>
                </a>
                <a href="{{ route('karyawan.index') }}" class="nav-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                    <i data-lucide="user-cog"></i>
                    <span>Karyawan</span>
                </a>
                <a href="{{ route('absensi.index') }}" class="nav-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                    <i data-lucide="calendar-check"></i>
                    <span>Absensi</span>
                </a>
                <a href="{{ route('jadwal.index') }}" class="nav-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                    <i data-lucide="calendar"></i>
                    <span>Jadwal</span>
                </a>
                <a href="{{ route('jenis-barang.index') }}" class="nav-item {{ request()->routeIs('jenis-barang.*') ? 'active' : '' }}">
                    <i data-lucide="package"></i>
                    <span>Jenis Barang</span>
                </a>
                <a href="{{ route('kas.index') }}" class="nav-item {{ request()->routeIs('kas.*') ? 'active' : '' }}">
                    <i data-lucide="wallet"></i>
                    <span>Kas</span>
                </a>
                
                <div style="border-top: 1px solid var(--emerald-700); margin: 1rem 0; padding-top: 1rem;">
                    <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i data-lucide="file-text"></i>
                        <span>Laporan</span>
                    </a>
                </div>
                
                @if(auth()->user()->isSuperuser())
                <div style="border-top: 1px solid var(--emerald-700); margin: 1rem 0; padding-top: 1rem;">
                    <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i data-lucide="shield"></i>
                        <span>User Management</span>
                    </a>
                </div>
                @endif
            </nav>

            <!-- User Info & Logout -->
            <div style="padding: 1rem; border-top: 1px solid var(--emerald-700);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                    <div style="width: 40px; height: 40px; background: var(--emerald-600); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="user" style="color: white; width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <p style="color: white; font-weight: 600; font-size: 0.875rem;">{{ auth()->user()->name }}</p>
                        <p style="color: var(--emerald-300); font-size: 0.75rem;">{{ auth()->user()->role_name }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                        <i data-lucide="log-out"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i data-lucide="x-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
