<nav class="nxl-navigation">
    <div class="navbar-wrapper">

        <!-- HEADER / LOGO -->
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}"
                     class="logo logo-lg"
                     style="max-width: 100%; height: auto;"
                     alt="logo">
                <img src="{{ asset('assets/images/logo-abbr.png') }}"
                     class="logo logo-sm"
                     alt="logo">
            </a>
        </div>

        <!-- MENU -->
        <div class="navbar-content">
            <ul class="nxl-navbar">

                <!-- DASHBOARD -->
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

                <!-- MENU -->
                <li class="nxl-item nxl-caption">
                    <label>Menu</label>
                </li>

                <!-- JOB FINISHING -->
                <li class="nxl-item">
                    <a href="{{ route('finishing.job-finishing.index') }}" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-package"></i>
                        </span>
                        <span class="nxl-mtext">Job Finishing</span>
                    </a>
                </li>

                <!-- RIWAYAT FINISHING -->
                <li class="nxl-item">
                    <a href="{{ route('finishing.job-finishing.riwayat') }}" class="nxl-link">
                        <span class="nxl-micon">
                            <i class="feather-clock"></i>
                        </span>
                        <span class="nxl-mtext">Riwayat Finishing</span>
                    </a>
                </li>

                <!-- AKUN -->
                <li class="nxl-item nxl-caption">
                    <label>Akun</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('finishing.profile') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-user me-2"></i></span>
                        <span class="nxl-mtext">Pengaturan Profil</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
