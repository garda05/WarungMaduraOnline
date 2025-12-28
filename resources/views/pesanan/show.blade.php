<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">
            Detail Pesanan
        </h1>

        <div class="bg-white p-6 rounded-xl shadow">

            <p class="font-semibold">
                Kode Pesanan: {{ $pesanan->kode_pesanan }}
            </p>

            <p class="text-sm text-gray-500 mb-4">
                {{ $pesanan->created_at->format('d M Y • H:i') }}
            </p>

            <p class="mb-4">
                Status:
                <span class="font-semibold capitalize">
                    {{ str_replace('_', ' ', $pesanan->status) }}
                </span>
            </p>

            @if ($pesanan->status === 'menunggu_pembayaran')
                <form action="{{ route('pesanan.bayar', $pesanan->id) }}" method="POST">
                    @csrf
                    <button class="bg-[#CC561E] text-white px-6 py-2 rounded-lg">
                        Konfirmasi Pembayaran
                    </button>
                </form>

                <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 text-sm">
                        Batalkan Pesanan
                    </button>
                </form>
            @endif

            <hr class="mt-2 my-4">

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
            <a href="{{ route('pesanan.index') }}"
                class="inline-block px-4 py-2 bg-gray-500 rounded-lg text-sm text-white hover:bg-gray-400">
                ← Kembali
            </a>
        </div>
    </div>
</x-app-layout>
