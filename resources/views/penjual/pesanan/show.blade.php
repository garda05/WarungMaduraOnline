<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">
            Detail Pesanan
        </h1>

        <div class="bg-white p-6 rounded-xl shadow">

            <p class="font-semibold">
                Kode: {{ $pesanan->kode_pesanan }}
            </p>

            <p class="text-sm text-gray-500 mb-4">
                {{ $pesanan->created_at->format('d M Y • H:i') }}
            </p>

            <p class="mb-2">
                Status:
                <strong>{{ str_replace('_', ' ', $pesanan->status) }}</strong>
            </p>

            @if ($pesanan->status === 'sedang_disiapkan')
                <form method="POST" action="{{ route('pesanan.updateStatus', $pesanan->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="sedang_dikirim">

                    <button class="bg-black text-white px-6 py-2 rounded">
                        Tandai Sedang Dikirim
                    </button>
                </form>
            @elseif ($pesanan->status === 'sedang_dikirim')
                <form method="POST" action="{{ route('pesanan.updateStatus', $pesanan->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="selesai">

                    <button class="bg-green-600 text-white px-6 py-2 rounded">
                        Tandai Pesanan Selesai
                    </button>
                </form>
            @endif

            <hr class="my-4">

            @foreach ($pesanan->items as $item)
                <div class="flex justify-between text-sm mb-2">
                    <span>
                        {{ $item->barang->nama_barang }} x{{ $item->qty }}
                    </span>
                    <span>
                        Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                    </span>
                </div>
            @endforeach

            <hr class="my-4">

            <div class="flex justify-between font-bold">
                <span>Total</span>
                <span class="text-[#CC561E]">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('penjual.pesanan') }}"
                class="inline-block px-4 py-2 bg-gray-500 rounded-lg text-sm text-white hover:bg-gray-400">
                ← Kembali
            </a>
        </div>
    </div>
</x-app-layout>
