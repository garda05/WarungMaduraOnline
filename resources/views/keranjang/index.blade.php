<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">

        {{-- JIKA KERANJANG KOSONG --}}
        @if (empty($keranjang))
            <div class="bg-white p-10 rounded-xl shadow text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold mb-2">
                    Wah, keranjang belanjamu kosong
                </h2>
                <p class="text-gray-500">
                    Yuk pilih menu favoritmu dulu!
                </p>

                <a href="{{ route('dashboard') }}"
                   class="inline-block mt-6 bg-[#CC561E] text-white px-6 py-2 rounded-lg">
                    Lihat Menu
                </a>
            </div>

        {{-- JIKA ADA ISI --}}
        @else
            <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

            <div class="bg-white rounded-xl shadow divide-y">
                @php $total = 0; @endphp

                @foreach ($keranjang as $id => $item)
                    @php
                        $subtotal = $item['harga'] * $item['qty'];
                        $total += $subtotal;
                    @endphp

                    <div class="flex justify-between items-center p-4">
                        <div class="flex items-center gap-4">
                            @if ($item['foto'])
                                <img src="{{ asset('storage/'.$item['foto']) }}"
                                     class="w-16 h-16 object-cover rounded-lg">
                            @endif

                            <div>
                                <p class="font-semibold">{{ $item['nama'] }}</p>
                                <p class="text-sm text-gray-500">
                                    Qty: {{ $item['qty'] }}
                                </p>
                                <p class="text-sm font-semibold text-[#CC561E]">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- HAPUS --}}
                        <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="text-red-600 text-sm hover:underline">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- TOTAL + PESAN --}}
            <div class="flex justify-between items-center mt-6">
                <p class="text-lg font-bold">
                    Total:
                    <span class="text-[#CC561E]">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </p>

                <form action="{{ route('keranjang.pesan') }}" method="POST">
                    @csrf
                    <button
                        class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
