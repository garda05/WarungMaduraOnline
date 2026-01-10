<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'status',
        'total_harga',
        'hidden_by_pembeli',
        'hidden_by_penjual',
    ];

    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
