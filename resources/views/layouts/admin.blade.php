<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') - Rungsek</title>
    <link href="https://cdn.datatables.net/v/dt/dt-3.1.3/datatables.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        {{-- Navbar --}}
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">

                {{-- Sidebar Toggle --}}
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>

                {{-- Right Navbar --}}
                <ul class="navbar-nav ms-auto">

                    {{-- User Menu --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->username ?? 'User' }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>
                                    Profil
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>

        {{-- Sidebar --}}
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

            {{-- Brand --}}
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="brand-link">
                    <span class="brand-text fw-bold">
                        RUNGSEK
                    </span>
                </a>
            </div>

            {{-- Sidebar Menu --}}
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">

                        {{-- Dashboard --}}
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        {{-- Siswa --}}
                        @if (in_array(auth()->user()->role, ['admin', 'teacher']))
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}"
                                    class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>Data Siswa</p>
                                </a>
                            </li>
                        @endif

                        {{-- Data Siswa Saya --}}
                        @if (auth()->user()->role === 'student')
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}"
                                    class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-vcard"></i>
                                    <p>Data Saya</p>
                                </a>
                            </li>
                        @endif

                        {{-- Teachers --}}
                        @if (in_array(auth()->user()->role, ['admin', 'teacher']))
                            <li class="nav-item">
                                <a href="{{ route('teachers.index') }}"
                                    class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-badge"></i>
                                    <p>Data Guru</p>
                                </a>
                            </li>
                        @endif

                        {{-- Kelases --}}
                        @if (in_array(auth()->user()->role, ['admin', 'teacher']))
                            <li class="nav-item">
                                <a href="{{ route('classes.index') }}"
                                    class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-building"></i>
                                    <p>Data Kelas</p>
                                </a>
                            </li>
                        @endif

                        {{-- Subjects --}}
                        @if (in_array(auth()->user()->role, ['admin', 'teacher']))
                            <li class="nav-item">
                                <a href="{{ route('subjects.index') }}"
                                    class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-book"></i>
                                    <p>Mata Pelajaran</p>
                                </a>
                            </li>
                        @endif

                        {{-- Log Aktivitas --}}
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('activity-logs.index') }}"
                                    class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-clock-history"></i>
                                    <p>Log Aktivitas</p>
                                </a>
                            </li>
                        @endif

                        {{-- Profil --}}
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}"
                                class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-circle"></i>
                                <p>Profil</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="app-main">

            {{-- Content Header --}}
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">
                                @yield('page-title', 'Dashboard')
                            </h3>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                @if (!request()->routeIs('dashboard'))
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">
                                            Dashboard
                                        </a>
                                    </li>
                                @endif

                                @hasSection('breadcrumb-parent')
                                    <li class="breadcrumb-item">
                                        @yield('breadcrumb-parent')
                                    </li>
                                @endif

                                @hasSection('breadcrumb')
                                    <li class="breadcrumb-item active">
                                        @yield('breadcrumb')
                                    </li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Page Content --}}
            <div class="app-content">
                <div class="container-fluid">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Silakan perbaiki kesalahan berikut:</strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">
                Rungsek
            </div>

            <strong>
                &copy; {{ date('Y') }} Rungsek.
            </strong>
            Hak cipta dilindungi.
        </footer>

    </div>

    <script src="https://cdn.datatables.net/v/dt/dt-3.1.3/datatables.min.js"></script>
    <script>
        window.initDataTable = function (selector, options = {}) {
            const table = document.querySelector(selector);
            if (!table || typeof DataTable === 'undefined') return null;
            if (DataTable.isDataTable && DataTable.isDataTable(table)) return null;

            return new DataTable(table, Object.assign({
                pageLength: 10,
                order: [],
                autoWidth: false,
                layout: {
                    topStart: 'pageLength',
                    topEnd: 'search',
                    bottomStart: 'info',
                    bottomEnd: 'paging'
                },
                language: {
                    search: 'Cari:',
                    searchPlaceholder: 'Cari data...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    zeroRecords: 'Data tidak ditemukan',
                    emptyTable: 'Belum ada data.',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                }
            }, options));
        };
    </script>
    @stack('scripts')
</body>

</html>
