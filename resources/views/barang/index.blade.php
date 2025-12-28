<x-app-layout>
    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="flex justify-end mt-4 mb-4">
            <a href="{{ route('barang.create') }}"
                class="bg-black text-white px-4 py-2 rounded text-sm hover:bg-gray-800">
                + Tambah Produk
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 text-left text-sm">
                    <tr>
                        <th class="p-3">Foto</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Deskripsi</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Stok</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-sm">
                    @forelse($barangs as $barang)
                        <tr class="border-t">
                            <td class="p-3">
                                @if ($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}"
                                        class="h-14 w-14 object-cover rounded">
                                @else
                                    <div
                                        class="h-14 w-14 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td class="p-3 font-medium">
                                {{ $barang->nama_barang }}
                            </td>

                            <td class="p-3 text-gray-600">
                                {{ \Illuminate\Support\Str::limit($barang->deskripsi, 50, '...') }}
                            </td>

                            <td class="px-4 py-2 capitalize text-sm text-gray-600">
                                {{ $barang->kategori }}
                            </td>

                            <td class="p-3">
                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                            </td>

                            <td class="p-3">
                                {{ $barang->stok }}
                            </td>

                            <td class="p-3">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('barang.edit', $barang->id) }}"
                                        class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus produk?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                Belum ada produk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
