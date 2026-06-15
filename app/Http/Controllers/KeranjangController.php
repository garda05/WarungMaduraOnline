<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        return view('keranjang.index', compact('keranjang'));
    }

    public function tambah(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);
        $qty = (int) $validated['qty'];
        $keranjang = session()->get('keranjang', []);
        $qtyDiKeranjang = $keranjang[$barang->id]['qty'] ?? 0;

        if ($qtyDiKeranjang + $qty > $barang->stok) {
            return back()->with('error', 'Qty melebihi stok');
        }

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

        $pesanan = DB::transaction(function () use ($keranjang) {
            $items = [];
            $total = 0;

            foreach ($keranjang as $barangId => $item) {
                $barang = Barang::query()->lockForUpdate()->findOrFail($barangId);
                $qty = (int) $item['qty'];

                abort_if($qty < 1 || $qty > $barang->stok, 422, 'Stok barang tidak mencukupi.');

                $items[] = compact('barang', 'qty');
                $total += $barang->harga * $qty;
            }

            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'kode_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
                'total_harga' => $total,
                'status' => 'menunggu_pembayaran',
            ]);

            foreach ($items as ['barang' => $barang, 'qty' => $qty]) {
                PesananItem::create([
                    'pesanan_id' => $pesanan->id,
                    'barang_id' => $barang->id,
                    'qty' => $qty,
                    'harga' => $barang->harga,
                ]);
                $barang->decrement('stok', $qty);
            }

            return $pesanan;
        });

        session()->forget('keranjang');

        return redirect()->route('pesanan.show', $pesanan->id);
    }
}
