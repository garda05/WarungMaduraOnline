<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
                'gambar' => $barang->gambar,
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
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong');
        }

        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'kode_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
            'total_harga' => $total,
            'status' => 'menunggu_pembayaran',
        ]);


        foreach ($keranjang as $barangId => $item) {
            PesananItem::create([
                'pesanan_id' => $pesanan->id,
                'barang_id' => $barangId,
                'qty' => $item['qty'],
                'harga' => $item['harga'],
            ]);
            
            Barang::where('id', $barangId)->decrement('stok', $item['qty']);
        }

        session()->forget('keranjang');

        return redirect()->route('pesanan.show', $pesanan->id);
    }
}
