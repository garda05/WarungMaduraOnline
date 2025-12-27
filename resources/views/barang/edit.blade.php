<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Barang -->
                        <div class="mb-4">
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang"
                                :value="old('nama_barang', $barang->nama_barang)" required />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <!-- Harga -->
                        <div class="mb-4">
                            <x-input-label for="harga" :value="__('Harga')" />
                            <x-text-input id="harga" class="block mt-1 w-full" type="number" name="harga"
                                :value="old('harga', $barang->harga)" required />
                            <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                        </div>

                        <!-- Stok -->
                        <div class="mb-4">
                            <x-input-label for="stok" :value="__('Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok"
                                :value="old('stok', $barang->stok)" required />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <select name="kategori" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="makanan" {{ $barang->kategori == 'makanan' ? 'selected' : '' }}>Makanan
                                </option>
                                <option value="minuman" {{ $barang->kategori == 'minuman' ? 'selected' : '' }}>Minuman
                                </option>
                                <option value="dessert" {{ $barang->kategori == 'dessert' ? 'selected' : '' }}>Dessert
                                </option>
                                <option value="snack" {{ $barang->kategori == 'snack' ? 'selected' : '' }}>Snack
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>


                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <!-- Tombol -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>

                            <a href="{{ route('barang.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
