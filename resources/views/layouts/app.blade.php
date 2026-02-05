{{-- head --}}
@include('layouts.head')
<body>
    <div class="app-wrapper">
        <div class="loader-wrapper">
            <div class="loader_24"></div>
        </div>
        {{-- sidebar --}}
        @include('layouts.sidebar')

        <div class="app-content">
            <div class="">
                {{-- header --}}
                @include('layouts.header')

                @yield('content')

                <div class="go-top">
                    <span class="progress-value">
                        <i class="ti ti-arrow-up"></i>
                    </span>
                </div>
                <footer>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <p class="footer-text f-w-600 mb-0">© 2026 QRIN Created By Tecanusa.</p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

{{-- script --}}
@include('layouts.script')
</html>
