<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang (REST API)
     */
    public function index()
    {
        // Ini adalah data dummy (sementara) sebelum database siap
        $barang = [
            [
                'id' => 1,
                'nama_barang' => 'Beras Madura 5kg',
                'harga' => 75000,
                'stok' => 10
            ],
            [
                'id' => 2,
                'nama_barang' => 'Garam Tradisional',
                'harga' => 5000,
                'stok' => 50
            ],
            [
                'id' => 3,
                'nama_barang' => 'Minyak Goreng 1L',
                'harga' => 18000,
                'stok' => 20
            ]
        ];

        return response()->json([
            'success' => true,
            'message' => 'Daftar Barang Warung Madura',
            'data' => $barang
        ], 200);
    }
}
