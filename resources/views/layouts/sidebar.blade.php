<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="/dashboard">
            <img alt="QRIN Logo" src="{{ asset('frontend/logo.png') }}" style="width: 110px">
        </a>

        <span class="bg-light-primary toggle-semi-nav d-flex-center">
            <i class="ti ti-chevron-right"></i>
        </span>

        <div class="d-flex align-items-center nav-profile p-3">
            <span class="h-45 w-45 d-flex-center b-r-10 position-relative bg-danger m-auto">
                <img alt="avatar" class="img-fluid b-r-10"
                    src="{{ asset('backend') }}/assets/images/avatar/woman.jpg">
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
            <li class="no-sub{{ request()->is('dashboard') ? ' active' : '' }}">
                <a href="/dashboard">
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

                                // Generate collapse ID
                                $collapseId = str($menu['title'])->slug()->toString();

                                // Check if parent menu is active
                                $isParentActive = false;
                                $activeSubmenuRoute = '';

                                if (!empty($menu['submenus'])) {
                                    foreach ($menu['submenus'] as $submenu) {
                                        if (is_submenu_active($submenu['route'])) {
                                            $isParentActive = true;
                                            $activeSubmenuRoute = $submenu['route'];
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @canany($permissions)
                                @if (empty($menu['submenus']))
                                    @can($menu['permission'])
                                        <li class="{{ is_menu_active($menu['route']) ? 'active' : '' }}">
                                            <a href="{{ route($menu['route'] . '.index') }}">
                                                {!! $menu['icon'] !!}
                                                {{ __($menu['title']) }}
                                            </a>
                                        </li>
                                    @endcan
                                @else
                                    <li class="{{ $isParentActive ? 'active' : '' }}">
                                        <a aria-expanded="{{ $isParentActive ? 'true' : 'false' }}" data-bs-toggle="collapse"
                                            href="#{{ $collapseId }}" class="{{ $isParentActive ? 'active' : '' }}">
                                            {!! $menu['icon'] !!}
                                            {{ __($menu['title']) }}
                                        </a>
                                        <ul class="collapse{{ $isParentActive ? ' show' : '' }}" id="{{ $collapseId }}">
                                            @foreach ($menu['submenus'] as $submenu)
                                                @can($submenu['permission'])
                                                    <li class="{{ is_submenu_active($submenu['route']) ? 'active' : '' }}">
                                                        <a href="{{ route($submenu['route'] . '.index') }}"
                                                            class="{{ is_submenu_active($submenu['route']) ? 'active' : '' }}">
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
