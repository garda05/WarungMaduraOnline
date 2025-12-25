<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');

        $query = Barang::query();

        if ($kategori && $kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        $barangs = $query->latest()->get();

        return view('dashboard', compact('barangs', 'kategori'));
    }
}
