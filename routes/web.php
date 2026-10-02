<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShareController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // File routes
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::get('/files/upload', [FileController::class, 'create'])->name('files.create');
    Route::post('/files/upload', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/{file}', [FileController::class, 'show'])->name('files.show');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}/delete', [FileController::class, 'destroy'])->name('files.delete');
});

// Public share routes
Route::get('/s/{token}', [ShareController::class, 'show'])->name('share.show');
Route::get('/s/{token}/download', [ShareController::class, 'download'])->name('share.download');

require __DIR__.'/auth.php';
