<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_barang',
        'harga',
        'stok',
        'deskripsi',
        'kategori',
        'gambar',
    ];

    public function penjual()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
