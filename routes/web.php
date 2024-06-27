<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\AuthController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/registeract', [App\Http\Controllers\AuthController::class, 'registeract'])->name('registeract')->middleware('guest');
Route::post('/loginact', [App\Http\Controllers\AuthController::class, 'loginact'])->name('loginact')->middleware('guest');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/jadwal', [App\Http\Controllers\JadwalController::class, 'index'])->name('jadwal');
Route::post('/tambah_jadwal', [App\Http\Controllers\JadwalController::class, 'tambah_jadwal'])->name('tambah_jadwal');
Route::post('/update_jadwal', [App\Http\Controllers\JadwalController::class, 'update_jadwal'])->name('update_jadwal');
Route::get('/hapus_jadwal/{id}', [App\Http\Controllers\JadwalController::class, 'hapus_jadwal'])->name('hapus_jadwal');
Route::get('/tambah_barang', [App\Http\Controllers\BarangController::class, 'tambah_barang'])->name('tambah_barang');
Route::post('/tambah_barang_proses', [App\Http\Controllers\BarangController::class, 'tambah_barang_proses'])->name('tambah_barang_proses');
Route::get('/hapus_barang/{id}', [App\Http\Controllers\BarangController::class, 'hapus_barang'])->name('hapus_barang');
Route::get('/edit_barang/{id}', [App\Http\Controllers\BarangController::class, 'edit_barang'])->name('edit_barang');
Route::put('/update_barang/{id}', [App\Http\Controllers\BarangController::class, 'update_barang'])->name('update_barang');
Route::get('/jenis_acara', [App\Http\Controllers\JenisAcaraController::class, 'index'])->name('jenis_acara');
Route::post('/tambah_jenis_acara', [App\Http\Controllers\JenisAcaraController::class, 'tambah_jenis_acara'])->name('tambah_jenis_acara');
Route::get('/hapus_jenis_acara/{id}', [App\Http\Controllers\JenisAcaraController::class, 'hapus_jenis_acara'])->name('hapus_jenis_acara');
Route::post('/update_jenis_acara', [App\Http\Controllers\JenisAcaraController::class, 'update_jenis_acara'])->name('update_jenis_acara');
Route::get('/tambah_event', [App\Http\Controllers\EventController::class, 'tambah_event'])->name('tambah_event');
Route::post('/tambah_event_proses', [App\Http\Controllers\EventController::class, 'tambah_event_proses'])->name('tambah_event_proses');
Route::get('/hapus_event/{id}', [App\Http\Controllers\EventController::class, 'hapus_event'])->name('hapus_event');
Route::get('/edit_event/{id}', [App\Http\Controllers\EventController::class, 'edit_event'])->name('edit_event');
Route::put('/update_event/{id}', [App\Http\Controllers\EventController::class, 'update_event'])->name('update_event');
Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index'])->name('kelas');
Route::post('/tambah_kelas', [App\Http\Controllers\KelasController::class, 'tambah_kelas'])->name('tambah_kelas');
Route::post('/update_kelas', [App\Http\Controllers\KelasController::class, 'update_kelas'])->name('update_kelas');
Route::get('/hapus_kelas/{id}', [App\Http\Controllers\KelasController::class, 'hapus_kelas'])->name('hapus_kelas');

Route::get('/pembayaran_danpengambilan', [App\Http\Controllers\TransaksiController::class, 'pembayaran'])->name('pembayaran_danpengambilan');
Route::get('/pesanan_selesai', [App\Http\Controllers\TransaksiController::class, 'pesanan_selesai'])->name('pesanan_selesai');
Route::get('/detail_pesanan/{id}', [App\Http\Controllers\TransaksiController::class, 'detail_pesanan'])->name('detail_pesanan');
Route::post('/actpembayaran_danpengambilan', [App\Http\Controllers\TransaksiController::class, 'pembayaran_proses'])->name('pembayaran_danpengambilan_proses');

Route::get('/rekapabsen', [App\Http\Controllers\AbsenController::class, 'rekapabsen'])->name('rekapabsen');
Route::get('rekapabsen/{id}', [App\Http\Controllers\AbsenController::class, 'rekapabsenid'])->name('rekapabsenid');
Route::get('/data_materi/{id}', [App\Http\Controllers\KelasController::class, 'data_materi'])->name('data_materi')->middleware('auth');
Route::post('/tambah_materi', [App\Http\Controllers\KelasController::class, 'tambah_materi'])->name('tambah_materi')->middleware('auth');
Route::post('/update_materi', [App\Http\Controllers\KelasController::class, 'update_materi'])->name('update_materi')->middleware('auth');
Route::get('/hapus_materi/{id}', [App\Http\Controllers\KelasController::class, 'hapus_materi'])->name('hapus_materi')->middleware('auth');
});

Route::get('/halaman_keranjang', [App\Http\Controllers\TransaksiController::class, 'halaman_keranjang'])->name('halaman_keranjang')->middleware(['auth']);
Route::get('/tambah_qty/{id}', [App\Http\Controllers\TransaksiController::class, 'tambah_qty'])->name('tambah_qty')->middleware(['auth']);
Route::get('/kurang_qty/{id}', [App\Http\Controllers\TransaksiController::class, 'kurang_qty'])->name('kurang_qty')->middleware(['auth']);
Route::get('/reset_qty/{id}', [App\Http\Controllers\TransaksiController::class, 'reset_qty'])->name('reset_qty')->middleware(['auth']);
Route::get('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang')->middleware('auth');
Route::post('/pesan', [App\Http\Controllers\TransaksiController::class, 'pemesanan'])->name('pemesanan')->middleware(['auth']);
Route::post('/tambah_keranjang', [App\Http\Controllers\KeranjangController::class, 'tambah_keranjang'])->name('tambah_keranjang')->middleware(['auth','pelanggan']);
Route::get('/lihat_materiuser/{id}', [App\Http\Controllers\AbsenController::class, 'lihat_materiuser'])->name('lihat_materiuser')->middleware(['auth','pelanggan']);
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/absen', [App\Http\Controllers\AbsenController::class, 'index'])->name('absen')->middleware(['auth','pelanggan']);    
Route::post('/actabsen', [App\Http\Controllers\AbsenController::class, 'actabsen'])->name('actabsen')->middleware(['auth','pelanggan']);    
Route::get('/ipen', [App\Http\Controllers\EventController::class, 'index'])->name('ipen')->middleware('auth');
Route::get('/lihat_keranjang', [App\Http\Controllers\KeranjangController::class, 'lihat_keranjang'])->name('lihat_keranjang')->middleware('auth');
Route::get('/event_detail/{id}', [App\Http\Controllers\EventController::class, 'event_detail'])->name('event_detail');

Route::get('/pesanan_saya', [App\Http\Controllers\TransaksiController::class, 'pesanan_saya'])->name('pesanan_saya')->middleware(['auth']);
Route::get('/detailpesanan_saya/{id}', [App\Http\Controllers\TransaksiController::class, 'pesanan_saya_detail'])->name('pesanan_saya_detail')->middleware(['auth']);




