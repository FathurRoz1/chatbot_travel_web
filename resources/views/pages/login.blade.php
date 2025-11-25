<!doctype html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Login | Travel Malang ID</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Berry is trending dashboard template made using Bootstrap 5 design framework. Berry is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="codedthemes" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="https://www.travelmalang.id/wp-content/uploads/2023/07/favicon-travel-malang-150x150.png" type="image/x-icon" />
    
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
</head>
<!-- [Head] end -->

<!-- [Body] Start -->
<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <a href="#" class="d-flex justify-content-center">
                            <img src="{{ asset('assets/images/logo-travel-malang-new.png') }}" alt="image" style="width: 40% !important" class="img-fluid brand-logo" />
                        </a>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="auth-header">
                                    <h2 class="text-secondary mt-5"><b>Hi, Welcome Back</b></h2>
                                    <p class="f-16 mt-2">Enter your credentials to continue</p>
                                </div>
                            </div>
                        </div>
                        <form action="{{ url('/trylogin') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email address / Username" />
                                <label for="floatingInput">Email address / Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingInput1" name="password" placeholder="Password" />
                                <label for="floatingInput1">Password</label>
                            </div>
                            <div class="d-flex mt-1 justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" name="remember" type="checkbox" id="customCheckc1" checked="" />
                                    <label class="form-check-label text-muted" for="customCheckc1">Remember me</label>
                                </div>
                                {{-- <h5 class="text-secondary">Forgot Password?</h5> --}}
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-secondary">Sign In</button>
                            </div>
                        </form>
                        {{-- <hr />
                        <h5 class="d-flex justify-content-center">Don't have an account?</h5> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="loginToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/icon/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <!-- Show Toast on Error -->
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('loginToast');
            var toast = new bootstrap.Toast(toastEl, { delay: 3500 });
            toast.show();
        });
    </script>
    @endif

    <!-- Password Toggle Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Forgot Password Form Handler
            $('#fgPassForm').on('submit', function(e) {
                $('button[type="submit"]').prop('disabled', true);
                e.preventDefault();
                var formData = $(this).serialize();
            });

            // Password Toggle Handler
            $('.field-icon').on('click', function() {
                const $icon = $(this);
                const $input = $('#password');

                // Toggle tipe input
                const isPassword = $input.attr('type') === 'password';
                $input.attr('type', isPassword ? 'text' : 'password');

                // Ubah icon
                if (isPassword) {
                    $icon.attr('icon', 'fa-solid:eye-slash');
                } else {
                    $icon.attr('icon', 'fa-solid:eye');
                }
            });
        });
    </script>

    <!-- Theme Configuration -->
    <script>
        layout_change('light');
    </script>

    <script>
        font_change('Roboto');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>
</body>
<!-- [Body] end -->
</html>
