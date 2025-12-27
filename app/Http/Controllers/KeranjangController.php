<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        return view('keranjang.index', compact('keranjang'));
    }

    public function tambah(Request $request, Barang $barang)
    {
        $qty = (int) $request->qty;

        // validasi stok
        if ($qty > $barang->stok) {
            return back()->with('error', 'Qty melebihi stok');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$barang->id])) {
            $keranjang[$barang->id]['qty'] += $qty;
        } else {
            $keranjang[$barang->id] = [
                'nama' => $barang->nama_barang,
                'harga' => $barang->harga,
                'foto' => $barang->foto,
                'qty' => $qty,
            ];
        }

        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function pesan()
    {
        $keranjang = session()->get('keranjang', []);

        // ❌ kalau kosong
        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang masih kosong');
        }

        /*
         * nanti logic pesanan:
         * - simpan ke tabel orders
         * - kurangi stok barang
         */

        session()->forget('keranjang');

        return redirect()->route('dashboard')
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
