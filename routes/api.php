use App\Http\Controllers\Api\BarangController;

Route::get('/barang', [BarangController::class, 'index']);
