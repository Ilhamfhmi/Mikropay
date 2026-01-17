<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController; // <--- 1. WAJIB TAMBAH INI

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --- MANAJEMEN ROUTER ---
Route::resource('routers', RouterController::class);
// Route Cek Koneksi Mikrotik (Ping)
Route::get('/routers/{id}/test', [RouterController::class, 'testConnection'])->name('routers.test');

// --- MANAJEMEN PAKET ---
Route::resource('paket', PackageController::class); 

// --- MANAJEMEN TAGIHAN ---
Route::resource('tagihan', InvoiceController::class);
// Route Tombol "Bayar" (Ubah Status Lunas)
Route::put('/tagihan/{id}/pay', [InvoiceController::class, 'markAsPaid'])->name('tagihan.pay');

// --- MANAJEMEN PELANGGAN ---
Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/', [PelangganController::class, 'index'])->name('index');
    Route::get('/create', [PelangganController::class, 'create'])->name('create');
    Route::post('/', [PelangganController::class, 'store'])->name('store');
    Route::get('/{id}', [PelangganController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PelangganController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PelangganController::class, 'update'])->name('update');
    Route::delete('/{id}', [PelangganController::class, 'destroy'])->name('destroy');
});

// --- MANAJEMEN PEMBAYARAN (History) ---
Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');
Route::get('/pembayaran/{id}/print', [PaymentController::class, 'print'])->name('pembayaran.print');

// --- LAPORAN KEUANGAN ---
Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');

// Menggunakan SettingController agar bisa menyimpan data
Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');
Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');