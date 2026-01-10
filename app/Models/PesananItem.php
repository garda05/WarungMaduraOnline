<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $fillable = [
        'pesanan_id',
        'barang_id',
        'qty',
        'harga',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
