<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/peminjam', [PeminjamController::class, 'index'])
        ->name('peminjam.index');

    Route::resource('barang', BarangController::class);

    Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    Route::get('/peminjaman/export/pdf', [PeminjamanController::class, 'exportPdf'])
    ->name('peminjaman.export.pdf');

    Route::get('/peminjaman/export/excel', [PeminjamanController::class, 'exportExcel'])
        ->name('peminjaman.export.excel');

    Route::resource('peminjaman', PeminjamanController::class);
});

require __DIR__.'/auth.php';
