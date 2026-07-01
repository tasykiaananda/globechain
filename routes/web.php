<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// ... (rute yang sudah ada sebelumnya) ...
// Rute Khusus Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Rute Halaman Tabel Kelola (Read)
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/ports', [AdminController::class, 'ports'])->name('admin.ports');
    Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
});
// Rute Halaman Tabel Kelola (Read)
Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store'); // <-- 
Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

// --- TAMBAHKAN 3 BARIS INI UNTUK PELABUHAN ---
Route::get('/ports', [AdminController::class, 'ports'])->name('admin.ports');
Route::post('/ports', [AdminController::class, 'storePort'])->name('admin.ports.store');
Route::put('/ports/{id}', [AdminController::class, 'updatePort'])->name('admin.ports.update');
Route::delete('/ports/{id}', [AdminController::class, 'deletePort'])->name('admin.ports.delete');
    
Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
    
// --- TAMBAHKAN 3 BARIS INI UNTUK ARTIKEL ---
    Route::post('/articles', [AdminController::class, 'storeArticle'])->name('admin.articles.store');
    Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->name('admin.articles.update');
    Route::delete('/articles/{id}', [AdminController::class, 'deleteArticle'])->name('admin.articles.delete');

Route::get('/', [DashboardController::class, 'index']);

// Endpoint untuk mengambil data detail negara secara real-time via AJAX
Route::get('/country-detail', [DashboardController::class, 'getCountryDetail']);