<!--
=========================================================
* Material Dashboard 2 - v3.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
@include('templating.header')

<body class="g-sidenav-show  bg-gray-200">
    {{-- Sidebar --}}
    @include('templating.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('templating.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @include('sweetalert::alert')

            @yield('content')
            @include('templating.footer_halaman')
        </div>
    </main>
    @include('templating.seeting_tema')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

    @include('templating.footer_js')
    <!--   Core JS Files   -->
    
