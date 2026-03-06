<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/mood/update', [\App\Http\Controllers\DashboardController::class, 'updateMood'])
    ->middleware(['auth'])
    ->name('mood.update');

Route::post('/daily-reward', [\App\Http\Controllers\DashboardController::class, 'claimDaily'])
    ->middleware(['auth'])
    ->name('daily.claim');

// Quiz Routes
Route::get('/quiz/start/{level}', [\App\Http\Controllers\QuizController::class, 'start'])->name('quiz.start')->middleware('auth');
Route::get('/quiz/show', [\App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show')->middleware('auth');
Route::post('/quiz/answer', [\App\Http\Controllers\QuizController::class, 'answer'])->name('quiz.answer')->middleware('auth');
Route::post('/quiz/paw', [\App\Http\Controllers\QuizController::class, 'usePaw'])->name('quiz.paw')->middleware('auth');
Route::get('/quiz/results', [\App\Http\Controllers\QuizController::class, 'results'])->name('quiz.results')->middleware('auth');

// Store Routes
Route::get('/store', [\App\Http\Controllers\StoreController::class, 'index'])->name('store.index')->middleware('auth');
Route::post('/store/purchase/{item}', [\App\Http\Controllers\StoreController::class, 'purchase'])->name('store.purchase')->middleware('auth');
Route::post('/store/omikuji', [\App\Http\Controllers\StoreController::class, 'omikuji'])->name('store.omikuji')->middleware('auth');
Route::post('/store/redeem', [\App\Http\Controllers\StoreController::class, 'redeemVoucher'])->name('store.redeem')->middleware('auth');

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
