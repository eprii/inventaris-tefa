<nav class="tefa-navbar">
    <div class="tefa-navbar-wrapper">
        <div class="tefa-navbar-left">
            <a href="{{ Route::has('dashboard') ? route('dashboard') : route('barang.index') }}" class="tefa-brand">
                Inventaris TEFA
            </a>

            @if (Route::has('dashboard'))
                <a href="{{ route('dashboard') }}" class="tefa-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            @endif

            <a href="{{ route('peminjam.index') }}" class="tefa-nav-link {{ request()->routeIs('peminjam.*') ? 'active' : '' }}">
                Peminjam
            </a>

            <a href="{{ route('barang.index') }}" class="tefa-nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                Barang
            </a>

            <span class="tefa-divider"></span>

            <a href="{{ route('peminjaman.index') }}" class="tefa-nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                Peminjaman
            </a>
        </div>

        <div class="tefa-navbar-right">
            @if (Route::has('logout'))
                <form action="{{ route('logout') }}" method="POST" class="tefa-logout-form">
                    @csrf
                    <button type="submit" class="tefa-logout-button" onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </button>
                </form>
            @endif
        </div>
    </div>
</nav>
