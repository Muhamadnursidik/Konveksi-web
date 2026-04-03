<header class="nxl-header">
    <div class="header-wrapper">

        {{-- LEFT --}}
        <div class="header-left d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>

            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display:none">
                    <i class="feather-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="header-right ms-auto">
            <div class="d-flex align-items-center">

                {{-- Fullscreen --}}
                <div class="nxl-h-item d-none d-sm-flex">
                    <div class="full-screen-switcher">
                        <a href="javascript:void(0);" class="nxl-head-link me-0"
                            onclick="$('body').fullScreenHelper('toggle');">
                            <i class="feather-maximize maximize"></i>
                            <i class="feather-minimize minimize"></i>
                        </a>
                    </div>
                </div>
                <div class="nxl-h-item dark-light-theme">
                    <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                        <i class="feather-moon"></i>
                    </a>
                    <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none">
                        <i class="feather-sun"></i>
                    </a>
                </div>

                {{-- Notifications (dummy dulu) --}}
                <div class="dropdown nxl-h-item">
                    <a class="nxl-head-link me-3 position-relative" data-bs-toggle="dropdown">
                        <i class="feather-bell"></i>

                        @if ($unread > 0)
                            <span class="badge bg-danger nxl-h-badge">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown p-0" style="width: 320px">

                        <!-- HEADER -->
                        <div class="px-3 py-2 fw-semibold d-flex justify-content-between">
                            <span>Notifikasi</span>
                            @if ($unread > 0)
                                <small class="text-danger">{{ $unread }} baru</small>
                            @endif
                        </div>

                        <div class="dropdown-divider m-0"></div>

                        <!-- LIST NOTIF -->
                        <div style="max-height:300px; overflow-y:auto;">
                            @forelse($notifikasi as $notif)
                                <a href="{{ route('notif.read', $notif->id) }}"
                                    class="dropdown-item py-2 {{ !$notif->is_read ? 'bg-light' : '' }}">

                                    <div class="d-flex">
                                        <div class="me-2">
                                            <i class="feather-bell text-primary"></i>
                                        </div>

                                        <div>
                                            <div class="fw-semibold small">
                                                {{ $notif->judul }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $notif->pesan }}
                                            </div>
                                            <div class="text-muted" style="font-size:10px">
                                                {{ $notif->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-3 text-muted">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                        </div>

                        <div class="dropdown-divider m-0"></div>

                        <!-- FOOTER -->
                        <div class="text-center py-2">
                            <form method="POST" action="{{ route('notif.readAll') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm text-primary p-2">
                                    Tandai semua sebagai dibaca
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- User --}}
                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/avatar/default.png') }}"
                            class="img-fluid user-avtar" alt="user" />
                    </a>

                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/avatar/default.png') }}"
                                    class="img-fluid user-avtar" />
                                <div class="ms-2">
                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                    <span class="fs-12 text-muted">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="feather-log-out me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</header>
