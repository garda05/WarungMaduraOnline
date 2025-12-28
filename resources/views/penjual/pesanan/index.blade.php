<x-app-layout>
    <div class="max-w-6xl mx-auto py-4">

        {{-- HAPUS RIWAYAT --}}
        @if ($pesanans->where('status', 'selesai')->count())
            <form method="POST"
                  action="{{ route('penjual.pesanan.hapusHistory') }}"
                  class="mb-4 text-right">
                @csrf
                @method('DELETE')

                <button class="text-sm text-red-500 hover:underline">
                    Hapus Riwayat Pesanan Selesai
                </button>
            </form>
        @endif
        <div class="bg-white rounded-xl shadow divide-y">
            @forelse ($pesanans as $pesanan)
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">
                            {{ $pesanan->kode_pesanan }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $pesanan->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-sm capitalize">
                            {{ str_replace('_', ' ', $pesanan->status) }}
                        </span>

                        <a href="{{ route('pesanan.show', $pesanan->id) }}" class="text-[#CC561E] font-semibold">
                            Detail →
                        </a>
                    </div>
                </div>
            @empty
                <p class="p-6 text-center text-gray-500">
                    Belum ada pesanan
                </p>
            @endforelse
        </div>
    </div>
</x-app-layout>
