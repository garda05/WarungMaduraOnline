<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        {{-- Header kanan: tombol tambah (SATU AJA) --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('barang.create') }}"
               class="bg-[#CC561E] hover:bg-[#b74c1a] text-white px-4 py-2 rounded-lg shadow">
                + Tambah Produk
            </a>
        </div>

        {{-- Jika belum ada produk --}}
        @if($barangs->isEmpty())
            <div class="bg-white rounded-xl shadow p-10 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h2 class="text-xl font-semibold mb-2">
                    Belum ada produk
                </h2>
                <p class="text-gray-500">
                    Produk yang kamu tambahkan akan muncul di sini.
                </p>
            </div>
        @else
            {{-- Table --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Foto</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Harga</th>
                            <th class="px-4 py-3 text-left">Stok</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($barangs as $barang)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    @if($barang->foto)
                                        <img src="{{ asset('storage/'.$barang->foto) }}"
                                             class="h-12 w-12 object-cover rounded-lg">
                                    @else
                                        <div class="h-12 w-12 flex items-center justify-center bg-gray-200 rounded-lg">
                                            📷
                                        </div>
                                    @endif
                                </td>

                                <td class="px-4 py-3 font-medium">
                                    {{ $barang->nama_barang }}
                                    <div class="text-xs text-gray-500">
                                        {{ ucfirst($barang->kategori) }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3">
                                    @if($barang->stok > 0)
                                        <span class="text-green-600 font-semibold">
                                            {{ $barang->stok }}
                                        </span>
                                    @else
                                        <span class="text-red-500 font-semibold">
                                            Habis
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('barang.edit', $barang) }}"
                                           class="text-blue-600 hover:underline">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('barang.destroy', $barang) }}"
                                              onsubmit="return confirm('Yakin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</x-app-layout>
