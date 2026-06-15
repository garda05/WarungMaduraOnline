# Warung Madura Online

Warung Madura Online adalah aplikasi marketplace sederhana berbasis Laravel yang mempertemukan penjual dan pembeli. Proyek ini digunakan untuk Tugas Besar mata kuliah **Pengujian dan Implementasi Sistem (BBK2MAB2)** dengan implementasi pengujian manual, PEST, dan Selenium UI Testing.

## Fitur Utama

- Registrasi dan login sebagai `penjual` atau `pembeli`.
- Penjual mengelola produk melalui fitur CRUD.
- Pembeli memilih produk, mengisi keranjang, dan membuat pesanan.
- Konfirmasi pembayaran dan perubahan status pesanan.
- Pembatasan akses berdasarkan role dan kepemilikan data.
- Riwayat pesanan dan chat antara pengguna.

## Teknologi

- PHP 8.2+
- Laravel 12
- SQLite atau MySQL
- Tailwind CSS dan Vite
- PEST untuk feature testing
- Selenium WebDriver, pytest, dan Python untuk UI testing

## Persiapan Windows

Prasyarat: PHP 8.2+, Composer, Node.js, Python 3.8+, serta Google Chrome atau Microsoft Edge.

```powershell
git clone https://github.com/garda05/WarungMaduraOnline.git
cd WarungMaduraOnline
git checkout branch-garda

composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run build
```

Jika ekstensi PHP belum aktif, pastikan `fileinfo`, `zip`, `pdo_sqlite`, dan `sqlite3` telah diaktifkan pada `php.ini`.

Jalankan aplikasi:

```powershell
php artisan serve
```

Aplikasi dapat dibuka melalui `http://127.0.0.1:8000`.

## Akun Pengujian

| Role | Email | Password |
| --- | --- | --- |
| Penjual | `penjual@warung.test` | `password123` |
| Pembeli | `pembeli@warung.test` | `password123` |

Akun dan produk pengujian dibuat oleh `DatabaseSeeder` agar pengujian Selenium dapat dijalankan berulang kali.

## Pengerjaan Tugas Besar

Pengujian disusun mengikuti brief tugas besar dan handbook Selenium Windows.

### 1. Black Box Manual

Teknik yang digunakan:

- **Equivalence Partitioning (EP):** membagi input menjadi kelas valid dan tidak valid, misalnya login benar/salah serta qty positif/nonpositif.
- **Boundary Value Analysis (BVA):** menguji batas qty `0`, `1`, nilai stok, dan `stok + 1`.
- **State Transition:** menguji perpindahan status pesanan dari keranjang sampai selesai.

Contoh BVA qty keranjang:

| Test Case | Input | Hasil yang Diharapkan |
| --- | ---: | --- |
| BB-BVA-01 | `0` | Ditolak oleh validasi |
| BB-BVA-02 | `1` | Produk masuk keranjang |
| BB-BVA-03 | `stok` | Produk masuk keranjang |
| BB-BVA-04 | `stok + 1` | Pesan `Qty melebihi stok` |

### 2. White Box Manual

White Box menggunakan **Basis Path Testing**. Salah satu fungsi yang dianalisis adalah `KeranjangController::tambah()`.

Decision yang diuji:

1. Apakah jumlah qty melebihi stok?
2. Apakah barang sudah ada di keranjang?

Cyclomatic Complexity:

```text
V(G) = jumlah decision + 1
V(G) = 2 + 1 = 3
```

Independent path:

| Path | Alur |
| --- | --- |
| P1 | Qty melebihi stok, kemudian sistem menampilkan error |
| P2 | Barang sudah ada, kemudian qty ditambahkan |
| P3 | Barang belum ada, kemudian item baru dibuat |

Flow graph dan perhitungan detail dicantumkan dalam Bab White Box laporan.

### 3. Implementasi PEST

Feature test utama berada di `tests/Feature/WarungMaduraFlowTest.php`, meliputi:

- Login valid dan tidak valid.
- Pembatasan akses pembeli dan penjual.
- Kepemilikan produk dan pesanan.
- CRUD produk.
- BVA kuantitas keranjang.
- Checkout dan pengurangan stok.
- Pembatalan pesanan dan pengembalian stok.
- Validasi urutan state transition pesanan.

Jalankan seluruh test:

```powershell
php artisan test
```

Jalankan test tugas besar saja:

```powershell
php artisan test tests/Feature/WarungMaduraFlowTest.php
```

Output `PASS` digunakan sebagai bukti implementasi tools pada laporan.

### 4. Implementasi Selenium

Struktur Selenium mengikuti handbook:

```text
selenium-tests/
|-- config.py
|-- base_test.py
|-- test_login.py
|-- test_penjual.py
|-- test_pembeli.py
|-- test_state_transition.py
`-- requirements.txt
```

Browser dipilih otomatis: Google Chrome menjadi pilihan utama dan Microsoft Edge menjadi fallback.

Terminal pertama:

```powershell
php artisan migrate:fresh --seed
php artisan serve
```

Terminal kedua:

```powershell
cd selenium-tests
py -m venv .venv
Set-ExecutionPolicy -Scope Process Bypass
.\.venv\Scripts\Activate.ps1
py -m pip install -r requirements.txt
py -m pytest -v
```

Hasil verifikasi terakhir:

```text
14 passed
```

Jalankan bukti per bagian:

```powershell
py -m pytest test_login.py -v
py -m pytest test_penjual.py -v
py -m pytest test_pembeli.py -v
py -m pytest test_state_transition.py -v
```

### 5. State Transition Pesanan

```text
Keranjang
  -> Menunggu Pembayaran
  -> Sedang Disiapkan
  -> Sedang Dikirim
  -> Selesai
```

Sesuai brief, satu transisi dipetakan menjadi satu skenario pada `test_state_transition.py`:

| Test | Transisi |
| --- | --- |
| ST-01 | Keranjang ke Menunggu Pembayaran |
| ST-02 | Menunggu Pembayaran ke Sedang Disiapkan |
| ST-03 | Sedang Disiapkan ke Sedang Dikirim |
| ST-04 | Sedang Dikirim ke Selesai |

## Bukti untuk Laporan

Screenshot yang disarankan:

1. Hasil `php artisan test` dengan seluruh test berstatus PASS.
2. Hasil `py -m pytest -v` dengan ringkasan `14 passed`.
3. Hasil khusus `test_state_transition.py` dengan empat skenario PASSED.
4. Browser saat Selenium menjalankan login, CRUD produk, checkout, dan perubahan status.
5. Tabel EP/BVA, flow graph Basis Path, diagram state transition, serta rekap PASS/FAIL.

## Struktur Laporan

1. Latar Belakang
2. Black Box Manual: Equivalence Partitioning dan BVA
3. White Box Manual: Basis Path Testing dan flow graph
4. Implementasi PEST
5. Implementasi Selenium berdasarkan State Transition
6. Hasil dan Analisis
7. Referensi

Lembar pembagian tugas kelompok dan tanda tangan dilampirkan pada halaman terakhir laporan sesuai brief.
