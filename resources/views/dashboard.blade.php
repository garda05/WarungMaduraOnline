<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
        <!-- BANNER PROMO -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="bg-gradient-to-r from-[#F3CF7A] to-[#CC561E] text-black rounded-2xl p-14 shadow-lg">
                <h2 class="text-3xl font-bold mb-2">Mau transaksi lebih hemat?</h2>
                <p class="text-lg mb-6">Cek promo spesial Warung Madura!</p>
                <button class="bg-white text-[#CC561E] px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                    Cek Sekarang
                </button>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            <!-- SEARCH -->
            <div class="mb-10">
                <div class="relative">
                    <input type="text" placeholder="Cari di Warung Madura"
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 focus:border-[#CC561E] focus:ring-0 text-lg" />
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- KATEGORI -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold mb-5">Kategori Pilihan</h2>

                @php
                    $kategoris = [
                        'semua' => ['📦', 'Semua'],
                        'makanan' => ['🍽️', 'Makanan'],
                        'minuman' => ['☕', 'Minuman'],
                        'dessert' => ['🍰', 'Dessert'],
                        'snack' => ['🍕', 'Snack'],
                    ];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                    @foreach ($kategoris as $key => [$icon, $label])
                        <a href="{{ route('dashboard', ['kategori' => $key]) }}"
                            class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition
                            {{ request('kategori', 'semua') === $key
                                ? 'bg-[#FFF5EC] border-[#CC561E] shadow'
                                : 'bg-white border-gray-200 hover:border-[#CC561E]' }}">
                            <span class="text-3xl">{{ $icon }}</span>
                            <span class="font-semibold">{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- PRODUK -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

                @forelse($barangs as $barang)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden relative">

                        <!-- FOTO -->
                        @if ($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-4xl">📦</span>
                            </div>
                        @endif

                        <!-- BODY -->
                        <div class="p-4">
                            <h3 class="font-semibold text-sm truncate">
                                {{ $barang->nama_barang }}
                            </h3>

                            <p class="text-[#CC561E] font-bold mt-2 mb-1">
                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                            </p>

                            <p class="text-xs text-gray-500 mb-1">
                                {{ Str::limit($barang->deskripsi, 50) }}
                            </p>

                            <p class="text-xs text-gray-500 mb-4">
                                Stok: {{ $barang->stok }}
                            </p>

                            <!-- ACTION -->
                            @if (auth()->user()->role === 'pembeli')
                                @if ($barang->stok > 0)
                                    <form action="{{ route('keranjang.tambah', $barang->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="w-full border border-green-500 text-green-600 rounded-lg py-2 text-sm font-semibold
                       hover:bg-green-50 transition">
                                            + Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button
                                        class="w-full bg-gray-300 text-gray-500 rounded-lg py-2 text-sm cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            @endif

                            {{-- @if (auth()->user()->role === 'pembeli')
                                <form action="{{ route('keranjang.tambah', $barang->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="w-full bg-black text-white py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">
                                        + Keranjang
                                    </button>
                                </form>
                            @endif --}}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        Belum ada produk
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>
