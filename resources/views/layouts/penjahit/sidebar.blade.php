<nav class="nxl-navigation">
    <div class="navbar-wrapper">

        <!-- HEADER / LOGO -->
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}" class="logo logo-lg"
                    style="max-width: 100%; height: auto;" alt="logo">
                <img src="{{ asset('assets/images/logo-abbr.png') }}" class="logo logo-sm" alt="logo">
            </a>
        </div>

        <!-- MENU -->
        <div class="navbar-content">
            <ul class="nxl-navbar">

                {{-- DASHBOARD --}}
                <li class="nxl-item nxl-caption">
                    <label>Dashboard</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-home"></i>
                        </span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- MENU PENJAHIT --}}
                <li class="nxl-item nxl-caption">
                    <label>Menu</label>
                </li>

                {{-- DATA MODEL PAKAIAN --}}
                <li class="nxl-item">
                    <a href="{{ route('penjahit.data-model-pakaian.index') }}" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-box"></i>
                        </span>
                        <span class="nxl-mtext">Data Model Pakaian</span>
                    </a>
                </li>

                {{-- JOB JAHIT --}}
                <li class="nxl-item">
                    <a href="{{ route('penjahit.job-jahit.index') }}" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-scissors"></i>
                        </span>
                        <span class="nxl-mtext">Job Jahit</span>
                    </a>
                </li>

                {{-- RIWAYAT JAHIT --}}
                <li class="nxl-item">
                    <a href="{{ route('penjahit.job-jahit.riwayat') }}" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-clock"></i>
                        </span>
                        <span class="nxl-mtext">Riwayat Jahit</span>
                    </a>
                </li>

                {{-- Akun --}}
                <li class="nxl-item nxl-caption">
                    <label>Akun</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('penjahit.profile') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-user me-2"></i></span>
                        <span class="nxl-mtext">Pengaturan Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
