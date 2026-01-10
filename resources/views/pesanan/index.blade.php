<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        {{-- HAPUS RIWAYAT --}}
        @if ($pesanans->where('status', 'selesai')->count())
            <form method="POST" action="{{ route('pesanan.hapusHistory') }}" class="mb-4 text-right">
                @csrf
                @method('DELETE')

                <button class="text-sm text-red-500 hover:underline">
                    Hapus Riwayat Pesanan
                </button>
            </form>
        @endif

        {{-- JIKA BELUM ADA PESANAN --}}
        @if ($pesanans->count() === 0)
            <div class="text-center">
                <div class="bg-white p-10 rounded-xl shadow">
                    <div class="text-6xl mb-4">📄</div>
                    <h2 class="text-2xl font-bold mb-2">
                        Belum ada pesanan
                    </h2>
                    <p class="text-gray-500">
                        Pesananmu akan muncul setelah kamu checkout.
                    </p>
                </div>
            </div>

        {{-- JIKA SUDAH ADA PESANAN --}}
        @else
            <div class="space-y-3">
                @foreach ($pesanans as $pesanan)
                    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                        <div>
                            <p class="font-semibold">
                                {{ $pesanan->kode_pesanan }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $pesanan->created_at->format('d M Y • H:i') }}
                            </p>
                            <p class="mt-1 text-sm">
                                Status:
                                <span class="font-semibold capitalize">
                                    {{ str_replace('_', ' ', $pesanan->status) }}
                                </span>
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-bold text-[#CC561E]">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('pesanan.show', $pesanan->id) }}"
                               class="text-sm text-blue-600 hover:underline mt-1 inline-block">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
