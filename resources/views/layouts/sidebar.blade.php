<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="index.html">
            <img alt="QRIN Logo" src="{{ asset('frontend/logo.png') }}" style="width: 110px">
        </a>

        <span class="bg-light-primary toggle-semi-nav d-flex-center">
            <i class="ti ti-chevron-right"></i>
        </span>

        <div class="d-flex align-items-center nav-profile p-3">
            <span class="h-45 w-45 d-flex-center b-r-10 position-relative bg-danger m-auto">
                <img alt="avatar" class="img-fluid b-r-10"
                    src="{{ asset('backend') }}/assets/images/avatar/woman.jpg">
                <span
                    class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
            </span>
            <div class="flex-grow-1 ps-2">
                <h6 class="text-primary mb-0"> {{ auth()?->user()?->name }}</h6>
                <p class="text-muted f-s-12 mb-0">
                    {{ isset(auth()?->user()?->roles) ? implode(auth()?->user()?->roles?->map(fn($role) => $role->name)->toArray()) : '-' }}
                </p>
            </div>

            <div class="dropdown profile-menu-dropdown">
                <a aria-expanded="false" data-bs-auto-close="true" data-bs-placement="top"
                    data-bs-toggle="dropdown" role="button">
                    <i class="ti ti-settings fs-5"></i>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a class="f-w-500" href="{{ route('profile') }}" target="_blank">
                            <i class="ti ti-user-circle pe-1 f-s-20"></i> Detail Profile
                        </a>
                    </li>
                    <li class="app-divider-v dotted py-1"></li>
                    <li class="dropdown-item">
                        <a class="mb-0 text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout pe-1 f-s-20"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            <li class="no-sub">
                <a href="/dashboard">
                    <i class="ti ti-layout-dashboard fs-5 me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a aria-expanded="false" data-bs-toggle="collapse" href="#maps">
                    <i class="ti ti-users fs-5 me-2"></i>
                    User & Roles
                </a>
                <ul class="collapse" id="maps">
                    <li><a href="/users">Users</a></li>
                    <li><a href="/roles">Roles</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>
</nav>
