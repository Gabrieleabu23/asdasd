<?php

use App\Http\Controllers\Api\LocaliController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
use App\Http\Controllers\Api\PostController;
Route::get('/', [LocaliController::class, 'index'])->name('locali.index');
Route::delete('/locali', [LocaliController::class, 'destroy'])->name('locali.destroy');

require __DIR__ . '/auth.php';