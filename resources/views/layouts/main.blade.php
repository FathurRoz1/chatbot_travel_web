<!doctype html>
<html lang="en">
<!-- [Head] start -->
<head>
  <title>@yield('title', 'Dashboard | Travel Malang ID')</title>
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
  
  @stack('styles')
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

  @include('layouts.sidebar')

  @include('layouts.header')

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      @yield('content')
    </div>
  </div>
  <!-- [ Main Content ] end -->
  
  @include('layouts.footer')

  @stack('scripts')
</body>
<!-- [Body] end -->
</html>
