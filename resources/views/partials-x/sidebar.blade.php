<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a class="logo logo-dark" href="{{ route('dashboard.index') }}">
            <span class="fs-18 fw-bold text-info"><i class="ri-dribbble-fill"></i></span>
            <span class="fs-24 fw-bold text-success"> Toy Store</span>
        </a>
        <!-- Light Logo-->
        <a class="logo logo-light" href="{{ route('dashboard.index') }}">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.jpg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30">
            </span>
        </a>
        <button class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover"
            type="button">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav">
                <li class="menu-title fs-16"><span data-key="t-menu">เมนู</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard.index') }}">
                        <i class="ri-home-3-line"></i> <span>หน้าหลัก</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('users.profile', ['ref' => auth()->user()?->code]) }}">
                        <i class="ri-emotion-line"></i> <span>โปรไฟล์</span>
                    </a>
                </li>

                @if (auth()->user()?->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('users.index') }}">
                            <i class="ri-parent-line"></i> <span>พนักงาน</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('products.index') }}">
                        <i class="ri-shopping-bag-3-line"></i> <span>สินค้า</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('invoices.index') }}">
                        <i class="ri-refund-2-line"></i> <span>รายการขาย</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('masters*') == 1 ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#masters" role="button"
                        aria-expanded="{{ Request::is('masters*') == 1 ? true : false }}" aria-controls="masters">
                        <i class="ri-star-smile-line"></i> <span data-key="t-apps">หมวดหมู่ & แบรนด์</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('masters*') == 1 ? 'show' : '' }}"
                        id="masters">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('masters/brands*') == 1 ? 'active' : '' }}"
                                    data-key="t-chat" href="{{ route('masters.brands.index') }}">แบรนด์</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('masters/categories*') == 1 ? 'active' : '' }}"
                                    data-key="t-chat" href="{{ route('masters.categories.index') }}">หมวดหมู่</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
