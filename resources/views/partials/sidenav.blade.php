<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{ url('admin') }}">
                <img src="{{ asset('assets/img/brand/logo.png') }}" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') ? ' active' : '' }}" href="{{ url('admin') }}">
                            <i class="ni ni-shop text-green"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/students') || request()->is('admin/students/*') || request()->is('admin/rombels') ? ' active' : '' }}"
                            href="#navbar-students" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('admin/students') || request()->is('admin/students/*') || request()->is('admin/rombels') ? 'true' : 'false' }}"
                            aria-controls="navbar-students">
                            <i class="ni ni-single-02 text-primary"></i>
                            <span class="nav-link-text">Data Siswa</span>
                        </a>
                        <div class="collapse {{ request()->is('admin/students') || request()->is('admin/students/*') || request()->is('admin/rombels') ? 'show' : '' }}"
                            id="navbar-students">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('admin/students') }}"
                                        class="nav-link {{ request()->is('admin/students') ? 'active' : '' }}">Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/rombels') }}"
                                        class="nav-link {{ request()->is('admin/rombels') ? 'active' : '' }}">Rombel</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/spp') || request()->is('admin/spp/*') ? 'active' : '' }}"
                            href="{{ url('admin/spp') }}">
                            <i class="ni ni-chart-pie-35 text-danger"></i>
                            <span class="nav-link-text">Data SPP</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/transactions') ? ' active' : '' }}"
                            href="{{ url('admin/transactions') }}">
                            <i class="ni ni-map-big text-warning"></i>
                            <span class="nav-link-text">Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/invoice/*') ? ' active' : '' }}"
                            href="#navbar-invoice" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('admin/invoice/*') ? 'true' : 'false' }}"
                            aria-controls="navbar-invoice">
                            <i class="ni ni-archive-2 text-info"></i>
                            <span class="nav-link-text">Invoice</span>
                        </a>
                        <div class="collapse {{ request()->is('admin/invoice/*') ? 'show' : '' }}" id="navbar-invoice">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('admin/invoice/waiting') }}"
                                        class="nav-link {{ request()->is('admin/invoice/waiting') ? 'active' : '' }}">Waiting
                                        Payment</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/invoice/success') }}"
                                        class="nav-link {{ request()->is('admin/invoice/success') ? 'active' : '' }}">Success
                                        Payment</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/invoice/failed') }}"
                                        class="nav-link {{ request()->is('admin/invoice/failed') ? 'active' : '' }}">Failed</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">Admin Navigation</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/data') ? 'active' : '' }}"
                            href="{{ url('admin/data') }}">
                            <i class="ni ni-user-run"></i>
                            <span class="nav-link-text">Officer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/payment/*') ? ' active' : '' }}"
                            href="#navbar-laporan" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('admin/payment/*') ? 'true' : 'false' }}"
                            aria-controls="navbar-laporan">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="width: 14px; ;font-size: .9375rem;">
                                <title>file text</title>
                                <g stroke-width="1" fill="#212121" stroke="#212121" class="nc-icon-wrapper">
                                    <line fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" x1="4.5" y1="11.5" x2="11.5"
                                        y2="11.5" data-color="color-2"></line>
                                    <line fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" x1="4.5" y1="8.5" x2="11.5"
                                        y2="8.5" data-color="color-2"></line>
                                    <line fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-miterlimit="10" x1="4.5" y1="5.5" x2="6.5"
                                        y2="5.5" data-color="color-2"></line>
                                    <polygon fill="none" stroke="#212121" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        points="9.5,0.5 1.5,0.5 1.5,15.5 14.5,15.5 14.5,5.5 "></polygon>
                                    <polyline fill="none" stroke="#212121" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        points="9.5,0.5 9.5,5.5 14.5,5.5 "></polyline>
                                </g>
                            </svg>
                            <span class="nav-link-text" style="margin-left: 1.15rem">Laporan</span>
                        </a>
                        <div class="collapse {{ request()->is('admin/payment/*') ? 'show' : '' }}"
                            id="navbar-laporan">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('payment.reports') }}"
                                        class="nav-link {{ request()->routeIs('payment.reports') ? 'active' : '' }}">Pembayaran Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('payment.arrears') }}"
                                        class="nav-link {{ request()->routeIs('payment.arrears') ? 'active' : '' }}">Tunggakan Siswa</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}"
                            href="{{ url('admin/settings') }}">
                            <i class="ni ni-ui-04"></i>
                            <span class="nav-link-text">Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/log') ? 'active' : '' }}"
                            href="{{ url('admin/log') }}">
                            <i class="ni ni-book-bookmark"></i>
                            <span class="nav-link-text">Log Activity</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
