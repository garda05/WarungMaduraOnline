<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // =========================
    // PEMBELI - LIST PESANAN
    // =========================
    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->where('hidden_by_pembeli', false) // ⬅️ INI WAJIB
            ->latest()
            ->get();

        return view('pesanan.index', compact('pesanans'));
    }

    // =========================
    // PENJUAL - PESANAN MASUK
    // =========================
    public function indexPenjual()
    {
        $pesanans = Pesanan::whereHas('items.barang', function ($q) {
            $q->where('user_id', Auth::id()); // ⬅️ KONSISTEN
        })
            ->where('hidden_by_penjual', false)
            ->with(['items.barang', 'user'])
            ->latest()
            ->get();

        return view('penjual.pesanan.index', compact('pesanans'));
    }

    // =========================
    // DETAIL PESANAN
    // =========================
    public function show(Pesanan $pesanan)
    {
        // pembeli hanya boleh lihat pesanannya sendiri
        if (Auth::user()->role === 'pembeli' && $pesanan->user_id !== Auth::id()) {
            abort(403);
        }

        if (Auth::user()->role === 'penjual') {
            $this->authorizeSellerOrder($pesanan);
        }

        // arahkan view sesuai role
        if (Auth::user()->role === 'penjual') {
            return view('penjual.pesanan.show', compact('pesanan'));
        }

        return view('pesanan.show', compact('pesanan'));
    }

    // =========================
    // PEMBELI - KONFIRMASI BAYAR
    // =========================
    public function konfirmasiPembayaran(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($pesanan->status !== 'menunggu_pembayaran') {
            return back();
        }

        $pesanan->update([
            'status' => 'sedang_disiapkan'
        ]);

        return back()->with('success', 'Pembayaran dikonfirmasi');
    }

    // =========================
    // PENJUAL - UPDATE STATUS
    // =========================
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $this->authorizeSellerOrder($pesanan);

        $request->validate([
            'status' => 'required|in:sedang_disiapkan,sedang_dikirim,selesai'
        ]);

        $allowedTransitions = [
            'sedang_disiapkan' => 'sedang_dikirim',
            'sedang_dikirim' => 'selesai',
        ];

        abort_unless(
            ($allowedTransitions[$pesanan->status] ?? null) === $request->status,
            422,
            'Transisi status pesanan tidak valid.'
        );

        $pesanan->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status diperbarui');
    }

    // =========================
    // PEMBELI - BATAL PESANAN
    // =========================
    public function batal(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($pesanan->status !== 'menunggu_pembayaran') {
            return back();
        }

        DB::transaction(function () use ($pesanan) {
            $pesanan->load('items.barang');

            foreach ($pesanan->items as $item) {
                $item->barang?->increment('stok', $item->qty);
            }

            $pesanan->delete();
        });

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan dibatalkan');
    }

    // =========================
    // PEMBELI - HAPUS HISTORY
    // =========================
    public function hapusHistoryPembeli()
    {
        Pesanan::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->update([
                'hidden_by_pembeli' => true
            ]);

        return back()->with('success', 'Riwayat pesanan disembunyikan');
    }

    // =========================
    // PENJUAL - HAPUS HISTORY (HIDE)
    // =========================
    public function hapusHistoryPenjual()
    {
        Pesanan::where('hidden_by_penjual', false)
            ->where('status', 'selesai')
            ->whereHas('items.barang', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->update([
                'hidden_by_penjual' => true
            ]);

        return redirect()
            ->route('penjual.pesanan')
            ->with('success', 'Riwayat pesanan disembunyikan');
    }

    private function authorizeSellerOrder(Pesanan $pesanan): void
    {
        $ownsItem = $pesanan->items()
            ->whereHas('barang', fn ($query) => $query->where('user_id', Auth::id()))
            ->exists();

        abort_unless($ownsItem, 403);
    }
}
