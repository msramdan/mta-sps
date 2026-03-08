<style>
    nav .app-nav .main-nav > li.no-sub.active > a {
        color: rgba(var(--white), 1);
        background: rgba(var(--primary), 1);
    }
</style>
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('frontend/logo.png') }}" style="width: 180px">
        </a>

        <span class="bg-light-primary toggle-semi-nav d-flex-center">
            <i class="ti ti-chevron-right"></i>
        </span>

        <div class="d-flex align-items-center nav-profile p-3">
            <span class="h-45 w-45 d-flex-center rounded-circle overflow-hidden bg-transparent border position-relative m-auto">
                <img alt="avatar" class="img-fluid"
                    src="{{ auth()?->user()?->avatar ?? asset('backend/assets/images/avatar/woman.jpg') }}"
                    style="object-fit: cover; width: 100%; height: 100%;">
                <span class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
            </span>
            <div class="flex-grow-1 ps-2">
                <h6 class="text-primary mb-0"> {{ auth()?->user()?->name }}</h6>
                <p class="text-muted f-s-12 mb-0">
                    {{ isset(auth()?->user()?->roles) ? implode(auth()?->user()?->roles?->map(fn($role) => $role->name)->toArray()) : '-' }}
                </p>
            </div>

            <div class="dropdown profile-menu-dropdown">
                <a aria-expanded="false" data-bs-auto-close="true" data-bs-placement="top" data-bs-toggle="dropdown"
                    role="button">
                    <i class="ti ti-settings fs-5"></i>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <a class="f-w-500" href="{{ route('profile') }}">
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
            <li class="no-sub{{ request()->routeIs('dashboard.*') || request()->is('dashboard') ? ' active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="ti ti-layout-dashboard fs-5 me-2"></i>
                    Dashboard
                </a>
            </li>

            @foreach (config('generator.sidebars') as $sidebar)
                @if (isset($sidebar['permissions']))
                    @canany($sidebar['permissions'])
                        @foreach ($sidebar['menus'] as $menu)
                            @php
                                $permissions = empty($menu['permission'])
                                    ? $menu['permissions']
                                    : [$menu['permission']];

                                $routePrefix = $menu['route'] ? str($menu['route'])->remove('/') : null;
                            @endphp

                            @canany($permissions)
                                @if (empty($menu['submenus']))
                                    @can($menu['permission'])
                                        @php
                                            $isActive = false;
                                            if ($routePrefix) {
                                                $isActive =
                                                    request()->routeIs($routePrefix . '.*') ||
                                                    request()->routeIs($routePrefix . '.index') ||
                                                    request()->is($routePrefix) ||
                                                    request()->is($routePrefix . '/*');
                                            }
                                        @endphp
                                        <li class="no-sub{{ $isActive ? ' active' : '' }}">
                                            <a href="{{ $routePrefix ? route($routePrefix . '.index') : '#' }}">
                                                {!! $menu['icon'] !!}
                                                {{ __($menu['title']) }}
                                            </a>
                                        </li>
                                    @endcan
                                @else
                                    @php
                                        $collapseId = str($menu['title'])->slug()->toString();
                                        $isParentActive = false;
                                        foreach ($menu['submenus'] as $submenu) {
                                            $submenuRoute = str($submenu['route'])->remove('/');
                                            if (
                                                request()->routeIs($submenuRoute . '.*') ||
                                                request()->routeIs($submenuRoute . '.index') ||
                                                request()->is($submenuRoute) ||
                                                request()->is($submenuRoute . '/*')
                                            ) {
                                                $isParentActive = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    <li class="{{ $isParentActive ? 'active' : '' }}">
                                        <a aria-expanded="{{ $isParentActive ? 'true' : 'false' }}" data-bs-toggle="collapse"
                                            href="#{{ $collapseId }}" class="{{ $isParentActive ? 'active' : '' }}">
                                            {!! $menu['icon'] !!}
                                            {{ __($menu['title']) }}
                                        </a>
                                        <ul class="collapse{{ $isParentActive ? ' show' : '' }}" id="{{ $collapseId }}">
                                            @foreach ($menu['submenus'] as $submenu)
                                                @can($submenu['permission'])
                                                    @php
                                                        $submenuRoute = str($submenu['route'])->remove('/');
                                                        $isSubmenuActive =
                                                            request()->routeIs($submenuRoute . '.*') ||
                                                            request()->routeIs($submenuRoute . '.index') ||
                                                            request()->is($submenuRoute) ||
                                                            request()->is($submenuRoute . '/*');
                                                    @endphp
                                                    <li class="{{ $isSubmenuActive ? 'active' : '' }}">
                                                        <a href="{{ route($submenuRoute . '.index') }}"
                                                            class="{{ $isSubmenuActive ? 'active' : '' }}">
                                                            {{ __($submenu['title']) }}
                                                        </a>
                                                    </li>
                                                @endcan
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endcanany
                        @endforeach
                    @endcanany
                @endif
            @endforeach
        </ul>
    </div>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>
</nav>
