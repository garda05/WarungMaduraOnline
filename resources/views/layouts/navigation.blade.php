<!-- TOP NAVBAR -->
<nav class="bg-gradient-to-r from-[#F3CF7A] to-[#CC561E] shadow-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-20">

            <!-- Brand (kanan atas sesuai request) -->
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-white rounded-full flex items-center justify-center shadow">
                    <span class="text-2xl">🏪</span>
                </div>
                <span class="text-white text-xl font-bold tracking-wide">
                    Warung Madura
                </span>
            </div>

            <!-- User + Logout -->
            <div class="flex items-center gap-6">
                <div class="text-white text-right leading-tight">
                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                    @if (Auth::user()->role === 'penjual')
                        <span class="text-xs bg-white text-[#CC561E] px-2 py-0.5 rounded-full font-bold">
                            PENJUAL
                        </span>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 bg-white text-[#CC561E]
                               px-4 py-2 rounded-lg font-semibold
                               hover:bg-gray-100 active:scale-95 transition">
                        <span>🚪</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

<!-- BOTTOM MENU NAV -->
<nav class="bg-white border-b border-gray-200 sticky top-0 z-20 shadow-sm">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-4 h-14">

            @if (Auth::user()->role === 'pembeli')
                <!-- PEMBELI -->
                @php
                    $menuClass = 'flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition';
                    $active = 'bg-[#FFF5EC] text-[#CC561E]';
                    $inactive = 'text-gray-600 hover:bg-gray-100';
                @endphp

                <a href="{{ route('dashboard') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                    <span class="text-lg">📋</span> Menu
                </a>

                <a href="{{ route('keranjang.index') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('keranjang.*') ? $active : $inactive }}">
                    <span class="text-lg">🛒</span> Keranjang
                </a>

                <a href="{{ route('pesanan.index') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('pesanan.*') ? $active : $inactive }}">
                    <span class="text-lg">⚙️</span> Pesanan
                </a>

                <a href="{{ route('chat.index') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('chat.*') ? $active : $inactive }}">
                    <span class="text-lg">💬</span> Chat
                </a>
            @else
                <!-- PENJUAL -->
                @php
                    $menuClass = 'flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition';
                    $active = 'bg-[#FFF5EC] text-[#CC561E]';
                    $inactive = 'text-gray-600 hover:bg-gray-100';
                @endphp

                <a href="{{ route('dashboard') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
                    <span class="text-lg">🏠</span> Dashboard
                </a>

                <a href="{{ route('barang.index') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('barang.*') ? $active : $inactive }}">
                    <span class="text-lg">📦</span> Kelola Produk
                </a>

                <a href="{{ route('penjual.pesanan') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('penjual.pesanan*') ? $active : $inactive }}">
                    <span class="text-lg">📋</span> Pesanan Masuk
                </a>

                <a href="{{ route('chat.index') }}"
                    class="{{ $menuClass }} {{ request()->routeIs('chat.*') ? $active : $inactive }}">
                    <span class="text-lg">💬</span> Chat Pelanggan
                </a>
            @endif

        </div>
    </div>
</nav>
