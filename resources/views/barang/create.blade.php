<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h1>Tambah Barang</h1>

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <input type="text" name="nama_barang" placeholder="Nama Barang"><br>
        <input type="number" name="harga" placeholder="Harga"><br>
        <input type="number" name="stok" placeholder="Stok"><br>
        <textarea name="deskripsi" placeholder="Deskripsi"></textarea><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
