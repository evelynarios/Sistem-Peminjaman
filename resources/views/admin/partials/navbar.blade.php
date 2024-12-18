<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
    <div class="container-fluid gap-3 mx-2">
        <a class="navbar-brand" href="">
            <img src="/Assets/Logo_Unib.png" style="max-width: 50px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/dashboard">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/reservasi') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/reservasi">Submission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/history') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/history">History</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{  Request::is('admin/declined') ? 'active' : ' ' }}" aria-current="page" href="/admin/declined">Declined</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/kerusakan') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/kerusakan">Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/cancellation') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/cancellation">Cancellation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/facilities') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/facilities">Facility</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/kelas') ? 'active' : ' ' }}" aria-current="page"
                        href="/kelas">Kelas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/schedules') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/schedules">Schedule</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/users') ? 'active' : ' ' }}" aria-current="page"
                        href="/admin/users">User</a>
                </li> --}} 
            </ul>
        </div>

        <div class="flex-shrink-0 dropdown">
            <a class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                data-bs-toggle="dropdown" aria-expanded="false">
                Hello, {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="dropdown-item">Sign out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
