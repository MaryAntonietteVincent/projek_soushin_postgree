<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl shadow-none" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $title }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <!-- Add more items here if needed -->
            </div>
            <ul class="navbar-nav justify-content-end">
                @if (auth()->user()->role == 'pelanggan')
                    
                
                <li class="nav-item d-flex align-items-center">
                    <!-- Cart Icon with Notification Badge -->
                    <a href="{{ 'halaman_keranjang' }}" class="nav-link p-0 text-body position-relative">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <!-- Notification Badge -->
                        {{-- @if ($jumlah_pesanan > 0) --}}
                            
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $jumlah_pesanan }} <!-- Change this number dynamically based on cart items -->
                        </span>
                        {{-- @endif --}}
                    </a>
                </li>
                @endif
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link p-0 text-body" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link p-0 text-body">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link p-0 text-body" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1" aria-hidden="true"></i>{{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <i class="fa-solid fa-right-from-bracket"></i> <a href="{{ route('logout') }}">Logout</a>
                        </li>
                        <!-- Add more dropdown items here if needed -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>