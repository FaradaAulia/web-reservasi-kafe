<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MejaController as AdminMejaController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\ScanController as AdminScanController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\ReservasiController as CustomerReservasiController;
use App\Http\Controllers\Customer\CheckoutController as CustomerCheckoutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController as AuthAuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\RegisteredSessionController as AuthRegisteredSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController as AuthPasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController as AuthNewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController as AuthEmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController as AuthEmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationController as AuthEmailVerificationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController as AuthConfirmablePasswordController;


Route::redirect('/', '/login');

// Guest reservation route (public)
Route::post('/reservasi/guest-store', [CustomerReservasiController::class, 'storeGuest'])
    ->name('customer.reservasi.store.guest');

Route::middleware('auth')
    ->get('/dashboard', [RedirectController::class, 'index'])
    ->name('dashboard');

// Admin Panel Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('kategori', AdminKategoriController::class)->names('admin.kategori');
        Route::resource('menu', AdminMenuController::class)->names('admin.menu');
        Route::resource('meja', AdminMejaController::class)->names('admin.meja');
        
        // Pembayaran & Reservasi Management
        Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran.index');
        Route::post('/pembayaran/{id}/verifikasi', [AdminPembayaranController::class, 'verifikasi'])->name('admin.pembayaran.verifikasi');
        Route::post('/pembayaran/{id}/selesai', [AdminPembayaranController::class, 'selesai'])->name('admin.pembayaran.selesai');
        Route::post('/pembayaran/{id}/batal', [AdminPembayaranController::class, 'batal'])->name('admin.pembayaran.batal');
        
        // Scan QR Code
        Route::get('/scan', [AdminScanController::class, 'index'])->name('admin.scan.index');
        Route::post('/scan', [AdminScanController::class, 'check']);
        Route::post('/scan/check', [AdminScanController::class, 'check'])->name('admin.scan.check');
    });

// Customer Panel Routes
Route::middleware('auth')
    ->prefix('customer')
    ->group(function () {
        Route::get('/home', [CustomerHomeController::class, 'index'])->name('customer.home');
        Route::get('/reservasi', [CustomerReservasiController::class, 'index'])->name('customer.reservasi.index');
        Route::post('/reservasi/store', [CustomerReservasiController::class, 'store'])->name('customer.reservasi.store');
        Route::get('/reservasi/{id}/sukses', [CustomerReservasiController::class, 'sukses'])->name('customer.reservasi.sukses');
        
        // Checkout & Payment Receipt Upload
        Route::get('/checkout/{id}', [CustomerCheckoutController::class, 'index'])->name('customer.checkout.index');
        Route::post('/checkout/{id}/bayar', [CustomerCheckoutController::class, 'bayar'])->name('customer.checkout.bayar');
        Route::get('/checkout/{id}/qrcode', [CustomerCheckoutController::class, 'qrcode'])->name('customer.checkout.qrcode');
    });

require __DIR__.'/auth.php';

