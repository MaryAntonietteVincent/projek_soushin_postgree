<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="" target="_blank">
            <img src="{{ asset('assets/img/logos/projek.jpg') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Shoushin Projek</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">



            <li class="nav-item">
                <a class="nav-link text-white {{ Route::is('dashboard') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>


            @if (auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::is('jadwal') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('jadwal') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Jadwal dan Rekap absen</span>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::is('barang') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('barang') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <span class="nav-link-text ms-1">Data Barang</span>
                </a>
            </li>
            @if (auth()->user()->role == "pelanggan")
                
         
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::is('absen') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('absen') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Absen</span>
                </a>
            </li>
            @endif
            @if (auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::is('jenis_acara') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('jenis_acara') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">

                        </div>
                        <span class="nav-link-text ms-1">Data Jenis acara</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::is('kelas') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('kelas') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <span class="nav-link-text ms-1">Data Kelas Dan Materi</span>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::is('ipen') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('ipen') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <span class="nav-link-text ms-1">Event</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="../pages/billing.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Billing</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="../pages/virtual-reality.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Virtual Reality</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="../pages/rtl.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <span class="nav-link-text ms-1">RTL</span>
                    </a>
                </li> --}}
            {{-- <li class="nav-item">
                    <a class="nav-link text-white " href="../pages/notifications.html">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">notifications</i>
                        </div>
                        <span class="nav-link-text ms-1">Notifications</span>
                    </a>
                </li> --}}
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Transaksi
                </h6>
            </li>
            @if (auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::is('pembayaran_danpengambilan') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('pembayaran_danpengambilan') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Pembayaran Pesanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::is('pesanan_selesai') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('pesanan_selesai') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Transaksi Selesai</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->role == 'pelanggan')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::is('pesanan_saya') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('pesanan_saya') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Pesanan Saya</span>
                </a>
            </li> 
            @endif
            
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            {{-- <a class="btn btn-outline-primary mt-4 w-100"
                href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree"
                type="button">Documentation</a>
            <a class="btn bg-gradient-primary w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree"
                type="button">Upgrade to pro</a> --}}
        </div>
    </div>
</aside>
