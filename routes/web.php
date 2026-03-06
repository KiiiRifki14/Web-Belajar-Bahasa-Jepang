<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('regions', \App\Http\Controllers\Admin\RegionController::class);
    Route::resource('levels', \App\Http\Controllers\Admin\LevelController::class);
    Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
    Route::resource('items', \App\Http\Controllers\Admin\ItemController::class);
    Route::resource('secret_notes', \App\Http\Controllers\Admin\SecretNoteController::class);
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class);
});

require __DIR__ . '/auth.php';
