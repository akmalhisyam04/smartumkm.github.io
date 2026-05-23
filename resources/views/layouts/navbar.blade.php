<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-file-description"></i>
                    <span class="ms-2">
                        @yield('title', 'Dashboard')
                    </span>
                </a>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                {{-- Tombol / Informasi Role --}}
                <li class="nav-item me-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary rounded-3 fs-2 fw-semibold px-3 py-2">
                            <i class="ti ti-user-check me-1"></i>
                            {{ session('role') ?? 'Guest' }}
                        </span>
                    </div>
                </li>

                {{-- Dropdown Profile --}}
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Profile" width="35" height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <div class="d-flex justify-content-center align-items-center gap-2 dropdown-item text-muted">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">{{ session('role') ?? 'User' }}</p>
                            </div>
                            {{-- <div class="d-flex align-items-center gap-2 dropdown-item text-muted">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">{{ session('email') ?? 'user@smartumkm.com' }}</p>
                            </div> --}}
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0)" class="btn btn-outline-primary mx-3 mt-2 d-block" 
                                onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                Logout
                            </a>
                            <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>