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
                        <h6 class="text-primary mb-0"> Ninfa Monaldo</h6>
                        <p class="text-muted f-s-12 mb-0">Web Developer</p>
                    </div>

                    <div class="dropdown profile-menu-dropdown">
                        <a aria-expanded="false" data-bs-auto-close="true" data-bs-placement="top"
                            data-bs-toggle="dropdown" role="button">
                            <i class="ti ti-settings fs-5"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">
                                <a class="f-w-500" href="profile.html" target="_blank">
                                    <i class="ph-duotone ph-user-circle pe-1 f-s-20"></i> Profile Details
                                </a>
                            </li>
                            <li class="app-divider-v dotted py-1"></li>
                            <li class="dropdown-item">
                                <a class="mb-0 text-danger" href="sign_in.html" target="_blank">
                                    <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="app-nav" id="app-simple-bar">
                <ul class="main-nav p-0 mt-2">
                    <li class="no-sub">
                        <a href="/dashboard">
                            <svg stroke="currentColor" stroke-width="1.5">
                                <use xlink:href="{{ asset('backend') }}/assets/svg/_sprite.svg#squares"></use>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a aria-expanded="false" data-bs-toggle="collapse" href="#maps">
                            <svg stroke="currentColor" stroke-width="1.5">
                                <use xlink:href="{{ asset('backend') }}/assets/svg/_sprite.svg#location"></use>
                            </svg>
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
