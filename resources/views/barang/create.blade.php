<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

        <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded-xl shadow space-y-4">
            @csrf

            <div>
                <label class="font-semibold">Foto Produk</label>
                <input type="file" name="gambar"
                    class="mt-1 block w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="font-semibold">Nama Barang</label>
                <input type="text" name="nama_barang"
                    class="w-full border rounded-lg p-2" required>
            </div>

            <div>
                <label class="font-semibold">Harga</label>
                <input type="number" name="harga"
                    class="w-full border rounded-lg p-2" required>
            </div>

            <div>
                <label class="font-semibold">Stok</label>
                <input type="number" name="stok"
                    class="w-full border rounded-lg p-2" required>
            </div>

            <div>
                <label class="font-semibold">Kategori</label>
                <select name="kategori" class="w-full border rounded-lg p-2">
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                    <option value="dessert">Dessert</option>
                    <option value="snack">Snack</option>
                </select>
            </div>

            <div>
                <label class="font-semibold">Deskripsi</label>
                <textarea name="deskripsi"
                    class="w-full border rounded-lg p-2"></textarea>
            </div>

            <button class="bg-[#CC561E] text-white px-6 py-2 rounded-lg">
                Simpan Produk
            </button>
        </form>
    </div>
</x-app-layout>
