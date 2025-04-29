<<<<<<< HEAD
<style>
    .collapse {
        transition: height 0.3s ease;
    }
</style>
<div class="min-height-300 bg-primary position-absolute w-100 ">
    <!-- Sidebar -->
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs fixed-start" id="sidenav-main">
        <div class="sidenav-header d-flex justify-content-between align-items-center p-3">
            <a class="navbar-logo m-0" href="#" id="sidenavToggle">
                <img src="../assets/img/logo-app.png" class="navbar-logo-img" alt="main_logo">
            </a>
        </div>

        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav flex-column">
                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.index') ? 'active' : '' }}" href="{{ route('employee.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li> --}}
                @else
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activityEmployee.index') ? 'active' : '' }}" href="{{ route('activityEmployee.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book-open text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Kegiatan BOK</span>
                    </a>
                </li> --}}
                @endif
                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activity.index') ? 'active' : '' }}" href="{{ route('activity.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tasks text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Kegiatan</span>
                    </a>
                </li> --}}
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('patient.index') ? 'active' : '' }}"
                        href="{{ route('patient.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Daftar Pasien</span>
                    </a>
                </li>

                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activityMonitoring.index') ? 'active' : '' }}" href="{{ route('activityMonitoring.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-laptop text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Monitoring Kegiatan</span>
                    </a>
                </li> --}}
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                        href="{{ route('profile') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-circle text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#submenuNew" role="button"
                        aria-controls="submenuNew" aria-expanded="false" id="toggleSubmenu">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-cogs text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Poli Umum</span>
                    </a>

                    <ul class="collapse list-unstyled ps-4" id="submenuNew">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('action.index') }}">
                                <i class="fas fa-cogs text-sm me-2"></i> Tindakan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cogs text-sm me-2"></i> Laporan
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </aside>

    <main class="main-content position-relative border-radius-lg content">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg fixed-top px-4 shadow-none bg-primary" id="navbarBlur">
            <div class="container-fluid py-1 px-3">
                <!-- Logo and Collapse Button -->
                <div class="d-flex align-items-center">
                    <a href="#" class="btn btn-outline-primary btn-sm font-weight-bold collapse-btn"
                        id="sidenavCollapseButton"
                        style="width: 50px; height: 50px; padding: 0; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bars" style="color: white; font-size: 24px;"></i>
                    </a>
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="navbar-brand-img">
                        <span class="text-white ms-2">PUSKESMAS TAMANGAPA</span>
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-white">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </main>




    <style>
        .navbar-brand-img {
            height: 50px;
            width: auto;
            object-fit: contain;
            margin-right: 10px;
        }

        .navbar-logo-img {
            height: 120px;
            width: auto;
            object-fit: contain;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                padding: 10px;
            }

            .navbar {
                padding: 5px 10px;
            }
        }

        .collapse-btn {
            z-index: 10;
            margin-right: 15px;
        }
    </style>
=======
<style>
    .collapse {
        transition: height 0.3s ease;
    }
</style>
<div class="min-height-300 bg-primary position-absolute w-100 ">
    <!-- Sidebar -->
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs fixed-start" id="sidenav-main">
        <div class="sidenav-header d-flex justify-content-between align-items-center p-3">
            <a class="navbar-logo m-0" href="#" id="sidenavToggle">
                <img src="../assets/img/logo-app.png" class="navbar-logo-img" alt="main_logo">
            </a>
        </div>

        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav flex-column">
                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.index') ? 'active' : '' }}" href="{{ route('employee.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li> --}}
                @else
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activityEmployee.index') ? 'active' : '' }}" href="{{ route('activityEmployee.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book-open text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Kegiatan BOK</span>
                    </a>
                </li> --}}
                @endif
                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activity.index') ? 'active' : '' }}" href="{{ route('activity.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tasks text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Kegiatan</span>
                    </a>
                </li> --}}
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('patient.index') ? 'active' : '' }}"
                        href="{{ route('patient.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Daftar Pasien</span>
                    </a>
                </li>

                @if (Auth::user()->role == 'admin')
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activityMonitoring.index') ? 'active' : '' }}" href="{{ route('activityMonitoring.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-laptop text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Monitoring Kegiatan</span>
                    </a>
                </li> --}}
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                        href="{{ route('profile') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-circle text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#submenuNew" role="button"
                        aria-controls="submenuNew" aria-expanded="false" id="toggleSubmenu">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-cogs text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Poli Umum</span>
                    </a>

                    <ul class="collapse list-unstyled ps-4" id="submenuNew">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('action.index') }}">
                                <i class="fas fa-cogs text-sm me-2"></i> Tindakan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cogs text-sm me-2"></i> Laporan
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </aside>

    <main class="main-content position-relative border-radius-lg content">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg fixed-top px-4 shadow-none bg-primary" id="navbarBlur">
            <div class="container-fluid py-1 px-3">
                <!-- Logo and Collapse Button -->
                <div class="d-flex align-items-center">
                    <a href="#" class="btn btn-outline-primary btn-sm font-weight-bold collapse-btn"
                        id="sidenavCollapseButton"
                        style="width: 50px; height: 50px; padding: 0; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bars" style="color: white; font-size: 24px;"></i>
                    </a>
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="navbar-brand-img">
                        <span class="text-white ms-2">PUSKESMAS TAMANGAPA</span>
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-white">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </main>




    <style>
        .navbar-brand-img {
            height: 50px;
            width: auto;
            object-fit: contain;
            margin-right: 10px;
        }

        .navbar-logo-img {
            height: 120px;
            width: auto;
            object-fit: contain;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                padding: 10px;
            }

            .navbar {
                padding: 5px 10px;
            }
        }

        .collapse-btn {
            z-index: 10;
            margin-right: 15px;
        }
    </style>
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
