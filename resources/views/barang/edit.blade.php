<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h1>Edit Barang</h1>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}"><br>
        <input type="number" name="harga" value="{{ $barang->harga }}"><br>
        <input type="number" name="stok" value="{{ $barang->stok }}"><br>
        <textarea name="deskripsi">{{ $barang->deskripsi }}</textarea><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
