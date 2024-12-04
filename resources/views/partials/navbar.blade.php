<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid gap-3 mx-2">
        <a class="navbar-brand">
            <img src="/Assets/Logo_Unib.png" style="max-width: 35px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav fs-5">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('homepage') ? 'active' : ' ' }}" href="/homepage">Home</a>
                </li>
                @auth
                    @if (auth()->user()->isAdmin)
                        {{-- Jika admin login, tidak menampilkan menu "Other" --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('facility') ? 'active' : ' ' }}" href="/facility">Facility</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('schedule') ? 'active' : ' ' }}" href="/schedule">Jadwal</a>
                        </li>
                        <li class="nav-item dropdown" id="Other">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Other
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="nav-link {{ Request::is('pembatalanpage') ? 'active' : ' ' }}"
                                        href="/pembatalanpage">Pembatalan</a></li>
                                <li><a class="nav-link {{ Request::is('laporankerusakanpage') ? 'active' : ' ' }}"
                                        href="/laporankerusakanpage">Laporan Kerusakan</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
        @auth
            <div class="flex-shrink-0 dropdown">
                <a class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Hello, {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    @if (auth()->user()->isAdmin)
                        <li><a class="dropdown-item" href="/admin/dashboard">Dashboard Admin</a></li>
                    @else
                        <li><a class="dropdown-item" href="/status_pemesanan">Status Pemesanan</a></li>
                        <li role="separator" class="dropdown-divider"></li>
                    @endif

                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="dropdown-item">Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
            {{-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form> --}}
        @else
        @endauth
    </div>
</nav>
