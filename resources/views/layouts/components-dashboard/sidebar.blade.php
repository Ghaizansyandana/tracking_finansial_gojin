<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="25" viewBox="0 0 25 42" ...>...</svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">FINANCE</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

    <li class="menu-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
        <a href="{{ route('dashboard.transaksi.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-transfer-alt"></i>
            <div data-i18n="Analytics">Transaksi Saya</div>
        </a>
    </li>

        @if(auth()->user()->role == 'admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Administrator</span>
            </li>
            
            <li class="menu-item {{ request()->segment(2) == 'users' ? 'active' : '' }}">
                <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div>Kelola Pengguna</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div>Pengaturan Sistem</div>
                </a>
            </li>
        @endif

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Keuangan</span>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div>Akun Keuangan</div>
            </a>
        </li>
    </ul>
</aside>