<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h1>Data Barang</h1>

    <a href="{{ route('barang.create') }}">Tambah Barang</a>

    <ul>
        @foreach ($barangs as $barang)
            <li>
                {{ $barang->nama_barang }} -
                {{ $barang->harga }} -
                {{ $barang->stok }}

                <a href="{{ route('barang.edit', $barang->id) }}">Edit</a>

                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
