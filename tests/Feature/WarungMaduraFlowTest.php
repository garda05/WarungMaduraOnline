<?php

use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function warungUser(string $role, string $email): User
{
    return User::factory()->create([
        'email' => $email,
        'password' => 'password123',
        'role' => $role,
    ]);
}

function warungProduct(User $penjual, array $overrides = []): Barang
{
    return Barang::create(array_merge([
        'user_id' => $penjual->id,
        'nama_barang' => 'Kopi Madura',
        'harga' => 12000,
        'stok' => 10,
        'deskripsi' => 'Kopi untuk pengujian.',
        'kategori' => 'minuman',
    ], $overrides));
}

it('memvalidasi login dan mengarahkan pengguna ke dashboard', function () {
    $pembeli = warungUser('pembeli', 'pembeli@example.test');

    $this->post('/login', [
        'email' => $pembeli->email,
        'password' => 'password-salah',
    ])->assertSessionHasErrors('email');

    $this->post('/login', [
        'email' => $pembeli->email,
        'password' => 'password123',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($pembeli);
});

it('membatasi CRUD produk kepada penjual pemilik produk', function () {
    $pemilik = warungUser('penjual', 'pemilik@example.test');
    $penjualLain = warungUser('penjual', 'lain@example.test');
    $pembeli = warungUser('pembeli', 'buyer@example.test');
    $barang = warungProduct($pemilik);

    $this->actingAs($pembeli)->get(route('barang.index'))->assertForbidden();
    $this->actingAs($penjualLain)->get(route('barang.edit', $barang))->assertForbidden();

    $this->actingAs($pemilik)->put(route('barang.update', $barang), [
        'nama_barang' => 'Kopi Madura Premium',
        'harga' => 15000,
        'stok' => 8,
        'deskripsi' => 'Sudah diperbarui.',
        'kategori' => 'minuman',
    ])->assertRedirect(route('barang.index'));

    expect($barang->fresh()->nama_barang)->toBe('Kopi Madura Premium');
});

it('membuat pesanan dari keranjang dan mengurangi stok', function () {
    $penjual = warungUser('penjual', 'seller@example.test');
    $pembeli = warungUser('pembeli', 'checkout@example.test');
    $barang = warungProduct($penjual, ['stok' => 5]);

    $this->actingAs($pembeli)
        ->post(route('keranjang.tambah', $barang), ['qty' => 2])
        ->assertSessionHas('success');

    $response = $this->actingAs($pembeli)->post(route('keranjang.pesan'));
    $pesanan = Pesanan::firstOrFail();

    $response->assertRedirect(route('pesanan.show', $pesanan));
    expect($pesanan->status)->toBe('menunggu_pembayaran')
        ->and($pesanan->total_harga)->toBe(24000)
        ->and($barang->fresh()->stok)->toBe(3);
});

it('menerapkan boundary value qty keranjang dan mengembalikan stok saat dibatalkan', function () {
    $penjual = warungUser('penjual', 'bva-seller@example.test');
    $pembeli = warungUser('pembeli', 'bva-buyer@example.test');
    $barang = warungProduct($penjual, ['stok' => 2]);

    $this->actingAs($pembeli)
        ->post(route('keranjang.tambah', $barang), ['qty' => 0])
        ->assertSessionHasErrors('qty');

    $this->actingAs($pembeli)
        ->post(route('keranjang.tambah', $barang), ['qty' => 3])
        ->assertSessionHas('error', 'Qty melebihi stok');

    $this->actingAs($pembeli)
        ->post(route('keranjang.tambah', $barang), ['qty' => 2])
        ->assertSessionHas('success');
    $this->actingAs($pembeli)->post(route('keranjang.pesan'));

    $pesanan = Pesanan::firstOrFail();
    expect($barang->fresh()->stok)->toBe(0);

    $this->actingAs($pembeli)
        ->delete(route('pesanan.batal', $pesanan))
        ->assertRedirect(route('pesanan.index'));

    expect($barang->fresh()->stok)->toBe(2)
        ->and(Pesanan::find($pesanan->id))->toBeNull();
});

it('menjalankan state transition pesanan hanya melalui urutan yang valid', function () {
    $penjual = warungUser('penjual', 'transition-seller@example.test');
    $pembeli = warungUser('pembeli', 'transition-buyer@example.test');
    $barang = warungProduct($penjual);
    $pesanan = Pesanan::create([
        'user_id' => $pembeli->id,
        'kode_pesanan' => 'ORD-TRANSISI',
        'status' => 'menunggu_pembayaran',
        'total_harga' => $barang->harga,
    ]);
    PesananItem::create([
        'pesanan_id' => $pesanan->id,
        'barang_id' => $barang->id,
        'qty' => 1,
        'harga' => $barang->harga,
    ]);

    $this->actingAs($pembeli)
        ->post(route('pesanan.bayar', $pesanan))
        ->assertSessionHas('success');
    expect($pesanan->fresh()->status)->toBe('sedang_disiapkan');

    $this->actingAs($penjual)
        ->patch(route('pesanan.updateStatus', $pesanan), ['status' => 'selesai'])
        ->assertStatus(422);

    $this->actingAs($penjual)
        ->patch(route('pesanan.updateStatus', $pesanan), ['status' => 'sedang_dikirim'])
        ->assertSessionHas('success');
    expect($pesanan->fresh()->status)->toBe('sedang_dikirim');

    $this->actingAs($penjual)
        ->patch(route('pesanan.updateStatus', $pesanan), ['status' => 'selesai'])
        ->assertSessionHas('success');
    expect($pesanan->fresh()->status)->toBe('selesai');
});

it('melarang penjual melihat pesanan milik penjual lain', function () {
    $pemilik = warungUser('penjual', 'order-owner@example.test');
    $penjualLain = warungUser('penjual', 'order-other@example.test');
    $pembeli = warungUser('pembeli', 'order-buyer@example.test');
    $barang = warungProduct($pemilik);
    $pesanan = Pesanan::create([
        'user_id' => $pembeli->id,
        'kode_pesanan' => 'ORD-PRIVATE',
        'status' => 'sedang_disiapkan',
        'total_harga' => $barang->harga,
    ]);
    PesananItem::create([
        'pesanan_id' => $pesanan->id,
        'barang_id' => $barang->id,
        'qty' => 1,
        'harga' => $barang->harga,
    ]);

    $this->actingAs($penjualLain)
        ->get(route('pesanan.show', $pesanan))
        ->assertForbidden();
});
