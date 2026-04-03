<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}" class="logo logo-lg" style="max-width: 100%; height: auto;" alt="logo">
                <img src="{{ asset('assets/images/logo-abbr.png') }}" class="logo logo-sm" alt="logo">
            </a>
        </div>

        <div class="navbar-content">
            <ul class="nxl-navbar">

                {{-- Dashboard --}}
                <li class="nxl-item nxl-caption">
                    <label>Dashboard</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>

                {{-- Master Data --}}
                <li class="nxl-item nxl-caption">
                    <label>Master Data</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('admin.bahan-baku.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-box"></i></span>
                        <span class="nxl-mtext">Bahan Baku</span>
                    </a>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('admin.model-pakaian.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-user"></i></span>
                        <span class="nxl-mtext">Model Pakaian</span>
                    </a>
                </li>

                {{-- User & Role --}}
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">User & Role</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a href="{{ route('admin.pemotong.index') }}" class="nxl-link">Pemotong</a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.penjahit.index') }}" class="nxl-link">Penjahit</a>
                        </li>
                        <li class="nxl-item">
                            <a href="{{ route('admin.finishing.index') }}" class="nxl-link">Finishing</a>
                        </li>
                    </ul>
                </li>

                {{-- Produksi --}}
                <li class="nxl-item nxl-caption">
                    <label>Produksi</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('admin.job-produksi.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-activity"></i></span>
                        <span class="nxl-mtext">Data Produksi</span>
                    </a>
                </li>

                {{-- Produk Jadi --}}
                <li class="nxl-item nxl-caption">
                    <label>Produk Jadi</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('admin.produk-jadi') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-package"></i></span>
                        <span class="nxl-mtext">Stok Produk Jadi</span>
                    </a>
                </li>

                {{-- Laporan --}}
                <li class="nxl-item nxl-caption">
                    <label>Laporan</label>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('laporan.produksi') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-file-text"></i></span>
                        <span class="nxl-mtext">Laporan Produksi</span>
                    </a>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('laporan.bahan-baku') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-file-text"></i></span>
                        <span class="nxl-mtext">Laporan Bahan Baku</span>
                    </a>
                </li>
                <li class="nxl-item">
                    <a href="{{ route('laporan.produk-jadi') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-file-text"></i></span>
                        <span class="nxl-mtext">Laporan Produk Jadi</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
