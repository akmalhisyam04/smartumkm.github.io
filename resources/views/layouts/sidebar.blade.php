<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between" style="margin-bottom: 4px; padding-bottom: 0;">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img d-flex align-items-center justify-content-center gap-2 text-decoration-none w-100">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="ti ti-building-store text-white fs-5"></i>
                </div>
                <span style="font-size: 20px; font-weight: 700; color: #1e293b;">
                    SMARTUMKM
                </span>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar="" style="margin-top: 0; padding-top: 0;">
            <ul id="sidebarnav" style="margin-bottom: 0; margin-top: 0; padding-top: 0;">
                {{-- DASHBOARD --}}
                <li class="nav-small-cap" style="padding: 2px 0 4px 0; margin-top: 0;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu" style="font-size: 13px;">UTAMA</span>
                </li>
                <li class="sidebar-item" style="margin-bottom: 2px;">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                        href="{{ route('dashboard') }}" aria-expanded="false"
                        style="padding: 8px 12px;">
                        <span><i class="ti ti-layout-dashboard"></i></span>
                        <span class="hide-menu" style="font-size: 15px;">Dashboard</span>
                    </a>
                </li>

                {{-- ================= ADMIN ================= --}}
                @if(session('role') == 'admin')
                    <li class="nav-small-cap" style="padding: 6px 0 4px 0; margin-top: 0;">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu" style="font-size: 13px;">DATA MASTER</span>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" 
                            href="{{ route('kategori.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-category"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Kategori</span>
                        </a>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('produk.*') ? 'active' : '' }}" 
                            href="{{ route('produk.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-package"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Manajemen Produk</span>
                        </a>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('stok.*') ? 'active' : '' }}" 
                            href="{{ route('stok.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-box"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Manajemen Stok</span>
                        </a>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('user.*') ? 'active' : '' }}" 
                            href="{{ route('user.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-users"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Manajemen User</span>
                        </a>
                    </li>
                @endif

                {{-- ================= ADMIN & KASIR ================= --}}
                @if(session('role') == 'admin' || session('role') == 'kasir')
                    <li class="nav-small-cap" style="padding: 6px 0 4px 0; margin-top: 0;">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu" style="font-size: 13px;">TRANSAKSI</span>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" 
                            href="{{ route('transaksi.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-shopping-cart"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Transaksi Penjualan</span>
                        </a>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('detail_transaksi.*') ? 'active' : '' }}" 
                            href="{{ route('detail-transaksi.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-receipt"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Detail Transaksi</span>
                        </a>
                    </li>
                @endif

                {{-- ================= ADMIN & PEMILIK ================= --}}
                @if(session('role') == 'admin' || session('role') == 'pemilik')
                    <li class="nav-small-cap" style="padding: 6px 0 4px 0; margin-top: 0;">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu" style="font-size: 13px;">LAPORAN</span>
                    </li>
                    <li class="sidebar-item" style="margin-bottom: 2px;">
                        <a class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" 
                            href="{{ route('laporan.index') }}" aria-expanded="false"
                            style="padding: 8px 12px;">
                            <span><i class="ti ti-file-report"></i></span>
                            <span class="hide-menu" style="font-size: 15px;">Laporan Penjualan</span>
                        </a>
                    </li>
                @endif

                {{-- ================= LOGOUT ================= --}}
                <li class="nav-small-cap" style="padding: 6px 0 4px 0; margin-top: 0;">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu" style="font-size: 13px;">AKUN</span>
                </li>
                <li class="sidebar-item" style="margin-bottom: 2px;">
                    <a class="sidebar-link" href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        aria-expanded="false"
                        style="padding: 8px 12px;">
                        <span><i class="ti ti-logout"></i></span>
                        <span class="hide-menu" style="font-size: 15px;">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>

            {{-- Card Profil / Role --}}
            <div class="unlimited-access bg-light-primary position-relative mb-7 mt-3 rounded-3 p-2 mx-2">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="unlimited-access-title pe-2">
                        <h6 class="fw-semibold fs-6 mb-2 text-dark">
                            SmartUMKM
                        </h6>
                        <span class="badge bg-primary fw-semibold" style="font-size: 10px;">
                            {{ session('role') ?? 'Guest' }}
                        </span>
                    </div>
                    <div class="unlimited-access-img text-end">
                        <img src="{{ asset('assets/images/backgrounds/shop.png') }}"
                            alt="shop"
                            class="img-fluid"
                            style="max-width: 70px; height: auto;">
                    </div>
                </div>
            </div>
        </nav>
    </div>
</aside>