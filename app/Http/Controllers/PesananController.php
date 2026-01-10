<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'status' => 'required|in:sedang_disiapkan,sedang_dikirim,selesai'
        ]);

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

        $pesanan->delete();

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
}