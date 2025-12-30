<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TransaksiSampahController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Auth::routes();

// Redirect root ke login
Route::get('/', function() {
    return redirect()->route('login');
});

// 💡 Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Semua fitur hanya setelah login
Route::middleware(['auth'])->group(function () {


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔹 CRUD Pengurus
    Route::resource('pengurus', PengurusController::class);
    Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus.index');
    Route::post('/pengurus/store', [PengurusController::class, 'store'])->name('pengurus.store');
    Route::post('/pengurus/update/{id}', [PengurusController::class, 'update'])->name('pengurus.update');
    Route::delete('/pengurus/destroy/{id}', [PengurusController::class, 'destroy'])->name('pengurus.destroy');
    Route::put('pengurus/update/{id}', [PengurusController::class, 'update'])->name('pengurus.update');

    // 🔹 CRUD Nasabah
    Route::resource('/nasabah', NasabahController::class);
    Route::get('/nasabah', [NasabahController::class, 'index'])->name('nasabah.index');
    Route::post('/nasabah/store', [NasabahController::class, 'store'])->name('nasabah.store');
    Route::put('/nasabah/update/{nasabah}', [NasabahController::class, 'update'])->name('nasabah.update');
    Route::delete('/nasabah/destroy/{nasabah}', [NasabahController::class, 'destroy'])->name('nasabah.destroy');

    // 🔹 CRUD Jenis Sampah
    Route::resource('/jenis', JenisSampahController::class);
    Route::get('/jenis', [JenisSampahController::class, 'index'])->name('jenis.index');
    Route::get('/jenis/create', [JenisSampahController::class, 'create'])->name('jenis.create');
    Route::get('/jenis/{id}/edit', [JenisSampahController::class, 'edit'])->name('jenis.edit');

    // 🔹 Transaksi Sampah
    Route::resource('transaksi', TransaksiSampahController::class)->only(['index','store','destroy']);
    Route::delete('/transaksi/{id}', [TransaksiSampahController::class, 'destroy'])->name('transaksi.destroy');

    // 🔹 Setoran Sampah
    Route::get('/setoran', [SetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/create', [SetoranController::class, 'create'])->name('setoran.create');
    Route::get('/setoran/{id}/edit', [SetoranController::class, 'edit'])->name('setoran.edit');

    // 🔹 Saldo Nasabah
    Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');
    Route::get('/saldo/create', [SaldoController::class, 'create'])->name('saldo.create');
    Route::post('/saldo', [SaldoController::class, 'store'])->name('saldo.store');
    Route::get('/saldo/{id}/edit', [SaldoController::class, 'edit'])->name('saldo.edit');
    Route::put('/saldo/{id}', [SaldoController::class, 'update'])->name('saldo.update');
    Route::delete('/saldo/{id}', [SaldoController::class, 'destroy'])->name('saldo.destroy');

    // 🔹 Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

    // 🔹 Backup Database
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/run', [BackupController::class, 'runBackup'])->name('backup.run');
    Route::get('/backup/download/{filename}', [BackupController::class, 'downloadBackup'])->name('backup.download');
    Route::delete('/backup/delete/{filename}', [BackupController::class, 'deleteBackup'])->name('backup.delete');
});

require __DIR__.'/auth.php';
