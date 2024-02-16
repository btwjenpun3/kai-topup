<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item @if (Request::is('*/dashboard')) active @endif">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>
                    @can('admin')
                        <li class="nav-item @if (Request::is('*/recharge')) active @endif">
                            <a class="nav-link" href="{{ route('recharge.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pig-money"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M15 11v.01" />
                                        <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377" />
                                        <path
                                            d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Recharge
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('reseller')
                        <li class="nav-item @if (Request::is('*/isi-saldo')) active @endif">
                            <a class="nav-link" href="{{ route('isi.saldo.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-brand-cashapp" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M17.1 8.648a.568 .568 0 0 1 -.761 .011a5.682 5.682 0 0 0 -3.659 -1.34c-1.102 0 -2.205 .363 -2.205 1.374c0 1.023 1.182 1.364 2.546 1.875c2.386 .796 4.363 1.796 4.363 4.137c0 2.545 -1.977 4.295 -5.204 4.488l-.295 1.364a.557 .557 0 0 1 -.546 .443h-2.034l-.102 -.011a.568 .568 0 0 1 -.432 -.67l.318 -1.444a7.432 7.432 0 0 1 -3.273 -1.784v-.011a.545 .545 0 0 1 0 -.773l1.137 -1.102c.214 -.2 .547 -.2 .761 0a5.495 5.495 0 0 0 3.852 1.5c1.478 0 2.466 -.625 2.466 -1.614c0 -.989 -1 -1.25 -2.886 -1.954c-2 -.716 -3.898 -1.728 -3.898 -4.091c0 -2.75 2.284 -4.091 4.989 -4.216l.284 -1.398a.545 .545 0 0 1 .545 -.432h2.023l.114 .012a.544 .544 0 0 1 .42 .647l-.307 1.557a8.528 8.528 0 0 1 2.818 1.58l.023 .022c.216 .228 .216 .569 0 .773l-1.057 1.057z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Isi Saldo
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item @if (Request::is('*/list-games') || Request::is('*/set-harga/*')) active @endif">
                            <a class="nav-link" href="{{ route('games.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-device-gamepad-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 5h3.5a5 5 0 0 1 0 10h-5.5l-4.015 4.227a2.3 2.3 0 0 1 -3.923 -2.035l1.634 -8.173a5 5 0 0 1 4.904 -4.019h3.4z" />
                                        <path d="M14 15l4.07 4.284a2.3 2.3 0 0 0 3.925 -2.023l-1.6 -8.232" />
                                        <path d="M8 9v2" />
                                        <path d="M7 10h2" />
                                        <path d="M14 10h2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    List Games
                                </span>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item dropdown @if (Request::is('*/topup/*')) active @endif">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-recharging"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7.038 4.5a9 9 0 0 0 -2.495 2.47" />
                                    <path d="M3.186 10.209a9 9 0 0 0 0 3.508" />
                                    <path d="M4.5 16.962a9 9 0 0 0 2.47 2.495" />
                                    <path d="M10.209 20.814a9 9 0 0 0 3.5 0" />
                                    <path d="M16.962 19.5a9 9 0 0 0 2.495 -2.47" />
                                    <path d="M20.814 13.791a9 9 0 0 0 0 -3.508" />
                                    <path d="M19.5 7.038a9 9 0 0 0 -2.47 -2.495" />
                                    <path d="M13.791 3.186a9 9 0 0 0 -3.508 -.02" />
                                    <path d="M12 8l-2 4h4l-2 4" />
                                    <path d="M12 21a9 9 0 0 0 0 -18" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Top Up
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    @foreach ($menus as $menu)
                                        @if ($menu->kategori == 'Games')
                                            <a class="dropdown-item"
                                                href="{{ route('realm.topup.index', ['slug' => $menu->slug]) }}">
                                                {{ $menu->nama }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="dropdown-menu-column">
                                    @foreach ($menus as $menu)
                                        @if ($menu->kategori == 'Pulsa')
                                            <a class="dropdown-item"
                                                href="{{ route('realm.topup.index', ['slug' => $menu->slug]) }}">
                                                {{ $menu->nama }}
                                            </a>
                                        @endif
                                    @endforeach
                                    <a class="dropdown-item"
                                        href="{{ route('realm.topup.index', ['slug' => 'pln']) }}">
                                        Token Listrik
                                    </a>
                                </div>
                                <div class="dropdown-menu-column">
                                    @foreach ($menus as $menu)
                                        @if ($menu->kategori == 'Voucher')
                                            <a class="dropdown-item"
                                                href="{{ route('realm.topup.index', ['slug' => $menu->slug]) }}">
                                                {{ $menu->nama }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @can('admin')
                        <li class="nav-item dropdown @if (Request::is('*/invoice/*')) active @endif">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-file-invoice" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 7l1 0" />
                                        <path d="M9 13l6 0" />
                                        <path d="M13 17l2 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Invoices
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="{{ route('invoice.realm.index') }}">
                                            Invoice Web
                                        </a>
                                        <a class="dropdown-item" href="{{ route('invoice.realm.admin') }}">
                                            Invoice Admin & Reseller
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('reseller')
                        <li class="nav-item @if (Request::is('*/invoice/*')) active @endif">
                            <a class="nav-link" href="{{ route('invoice.realm.reseller') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 7l1 0" />
                                    <path d="M9 13l6 0" />
                                    <path d="M13 17l2 0" />
                                </svg>
                                <span class="nav-link-title">
                                    Invoices
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item @if (Request::is('*/transaksi')) active @endif">
                            <a class="nav-link" href="{{ route('transaksi.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-transaction-dollar" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M20.8 13a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                                    <path d="M18 11v10" />
                                    <path d="M5 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M17 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M7 5h8" />
                                    <path d="M7 5v8a3 3 0 0 0 3 3h1" />
                                </svg>
                                <span class="nav-link-title">
                                    Transaksi
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item @if (Request::is('*/payment')) active @endif">
                            <a class="nav-link" href="{{ route('payment.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                        <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Payment
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item dropdown @if (Request::is('*/report/*')) active @endif">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-report-search" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                                        <path d="M18 12v-5a2 2 0 0 0 -2 -2h-2" />
                                        <path
                                            d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path d="M8 11h4" />
                                        <path d="M8 15h3" />
                                        <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                                        <path d="M18.5 19.5l2.5 2.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Report
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item" href="{{ route('report.index.profit') }}">
                                            Profit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item @if (Request::is('*/user')) active @endif">
                            <a class="nav-link" href="{{ route('user.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                </svg>
                                <span class="nav-link-title">
                                    User
                                </span>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item @if (Request::is('*/profile')) active @endif">
                        <a class="nav-link" href="{{ route('profile.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                            </svg>
                            <span class="nav-link-title">
                                Profile
                            </span>
                        </a>
                    </li>
                    @can('admin')
                        <li class="nav-item @if (Request::is('*/log')) active @endif">
                            <a class="nav-link" href="{{ route('log.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 8v4" />
                                    <path d="M12 16h.01" />
                                </svg>
                                <span class="nav-link-title">
                                    Log
                                </span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</header>
