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

    public function tambah(Barang $barang)
    {
        $keranjang = session()->get('keranjang', []);

        // kalau stok 0, langsung stop
        if ($barang->stok <= 0) {
            return back()->with('error', 'Stok barang habis');
        }

        if (isset($keranjang[$barang->id])) {

            // 🔒 LIMIT SESUAI STOK
            if ($keranjang[$barang->id]['qty'] >= $barang->stok) {
                return back()->with('error', 'Jumlah melebihi stok tersedia');
            }

            $keranjang[$barang->id]['qty']++;

        } else {
            $keranjang[$barang->id] = [
                'nama'  => $barang->nama_barang,
                'harga'=> $barang->harga,
                'foto' => $barang->foto,
                'qty'  => 1,
                'stok' => $barang->stok, // simpan stok buat validasi UI
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
