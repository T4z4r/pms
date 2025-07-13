<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => $title])
    @include('layouts.shared.head-css')
    <link rel="manifest" href="manifest.json">

</head>

<body>
    @php
        use App\Models\BrandSetting;
        $brandSetting = BrandSetting::firstOrCreate();
    @endphp

    {{-- Spinner component --}}
    <div class="request__spinner"></div>

    {{-- topbar --}}
    {{-- @include('layouts.shared.topbar') --}}
    {{-- /topbar --}}

    <div class="page-content">
        {{-- page loader --}}
        <div id="loadingOverlay" class="loading-overlay">
            <div class='loader' id="element-to-remove">
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--dot'></div>
                <div class='loader--text'></div>
            </div>
        </div>
        {{-- End of page loader --}}

             @include('layouts.shared.left-sidebar')


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">
                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    @include('layouts.shared.topbar')

                    @include('layouts.shared.page-header')
                </div>
                <!-- /page header -->

                <!-- Content area -->
                <div class="content" style="padding:6px !important;">
                    @yield('content')
                </div>
                <!-- /content area -->



                @include('layouts.shared.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    @yield('modal')


    <!-- Demo config -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
        <div class="position-absolute top-50 end-100 visible">
            <button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0"
                data-bs-toggle="offcanvas" data-bs-target="#demo_config">
                <i class="ph-gear"></i>
            </button>
        </div>

        <div class="offcanvas-header border-bottom py-0">
            <h5 class="offcanvas-title py-3">Demo configuration</h5>
            <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
                data-bs-dismiss="offcanvas">
                <i class="ph-x"></i>
            </button>
        </div>

        <div class="offcanvas-body">
            <div class="fw-semibold mb-2">Color mode</div>
            <div class="list-group mb-3">
                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-sun ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">Light theme</span>
                                <div class="fs-sm text-muted">Set light theme or reset to default</div>
                            </div>
                        </div>
                        <input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
                            value="light" checked>
                    </div>
                </label>

                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-moon ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">Dark theme</span>
                                <div class="fs-sm text-muted">Switch to dark theme</div>
                            </div>
                        </div>
                        <input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
                            value="dark">
                    </div>
                </label>

                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-translate ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">Auto theme</span>
                                <div class="fs-sm text-muted">Set theme based on system mode</div>
                            </div>
                        </div>
                        <input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
                            value="auto">
                    </div>
                </label>
            </div>

            <div class="fw-semibold mb-2">Direction</div>
            <div class="list-group mb-3">
                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-translate ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">RTL direction</span>
                                <div class="text-muted">Toggle between LTR and RTL</div>
                            </div>
                        </div>
                        <input type="checkbox" name="layout-direction" value="rtl"
                            class="form-check-input cursor-pointer m-0 ms-auto">
                    </div>
                </label>
            </div>

            <div class="fw-semibold mb-2">Layouts</div>
            <div class="row">
                <div class="col-12">
                    <a href="index.html" class="d-block mb-3">
                        <img src="https://demo.interface.club/limitless/assets/images/layouts/layout_1.png"
                            class="img-fluid img-thumbnail bg-primary bg-opacity-20 border-primary" alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="../../layout_2/full/index.html" class="d-block mb-3">
                        <img src="https://demo.interface.club/limitless/assets/images/layouts/layout_2.png"
                            class="img-fluid img-thumbnail" alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="../../layout_3/full/index.html" class="d-block mb-3">
                        <img src="https://demo.interface.club/limitless/assets/images/layouts/layout_3.png"
                            class="img-fluid img-thumbnail" alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="../../layout_4/full/index.html" class="d-block mb-3">
                        <img src="https://demo.interface.club/limitless/assets/images/layouts/layout_4.png"
                            class="img-fluid img-thumbnail" alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="../../layout_5/full/index.html" class="d-block mb-3">
                        <img src="https://demo.interface.club/limitless/assets/images/layouts/layout_5.png"
                            class="img-fluid img-thumbnail" alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="../../layout_6/full/index.html" class="d-block">
                        <img src="https://demo.interface.club/limitless/assets/images/layouts/layout_6.png"
                            class="img-fluid img-thumbnail" alt="">
                    </a>
                </div>
            </div>
        </div>


    </div>
    <!-- /demo config -->
    @stack('footer-script')


    <script>

            $(document).ready(function() {
                $('.select2').each(function() {
                    $(this).select2({ dropdownParent: $(this).parent()});
                })
            });
        $(document).ready(function() {
            $(".alert").slideDown(500).delay(5000).slideUp(300);
        });
    </script>

    <script>
        const phoneInput = document.getElementById('phone-input');

        // Check if phoneInput exists before adding the event listener
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value;

                // Only format if there is input
                if (value) {
                    // Remove all non-digit characters except the "+"
                    value = value.replace(/(?!^\+)\D/g, '');

                    // Format the value with spaces for better readability
                    if (value.length > 1) {
                        value = value.replace(/^(\+\d{1,3})(\d{1,3})?(\d{1,4})?(\d{1,4})?/, function(_, c1, c2, c3,
                            c4) {
                            return [c1, c2, c3, c4].filter(Boolean).join(' ');
                        });
                    }
                }

                e.target.value = value;
            });
        }
        $(document).ready(function() {
            $(".alert").slideDown(500).delay(5000).slideUp(300);
        });


        // SweetAlert2 for success messages
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#001f3f',
                    confirmButtonText: 'Ok'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ff0000',
                    confirmButtonText: 'Ok'
                });
            @endif
        });
    </script>


    <script>
        // Trigger an installation prompt to the user
        if ('serviceWorker' in navigator && 'beforeinstallprompt' in window) {
            window.addEventListener('beforeinstallprompt', (event) => {
                event.preventDefault();
                const installPrompt = event;
                const installButton = document.createElement('button');
                installButton.textContent = 'Install App';
                installButton.classList.add('btn', 'btn-main', 'w-100', 'py-0', 'mb-3');
                installButton.addEventListener('click', () => {
                    installPrompt.prompt();
                    installPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                        } else {
                            console.log('User dismissed the install prompt');
                        }
                        installPrompt = null;
                    });
                });
                document.querySelector('.login-card .card-body').appendChild(installButton);
            });
        }
    </script>
        @stack('footer-script')

</body>

</html>
