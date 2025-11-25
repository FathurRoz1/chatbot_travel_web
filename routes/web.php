<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
})->name('login');

Route::post('/trylogin', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/dataset', [DatasetController::class, 'index'])->name('dataset.index');
    Route::get('/dataset/get-data', [DatasetController::class, 'getData'])->name('dataset.get-data');
    Route::post('/dataset', [DatasetController::class, 'store'])->name('dataset.store');
    Route::get('/dataset/{id}', [DatasetController::class, 'show'])->name('dataset.show');
    Route::put('/dataset/{id}', [DatasetController::class, 'update'])->name('dataset.update');
    Route::delete('/dataset/{id}', [DatasetController::class, 'destroy'])->name('dataset.destroy');
    Route::post('/dataset/{id}/restore', [DatasetController::class, 'restore'])->name('dataset.restore');
    Route::delete('/dataset/{id}/force', [DatasetController::class, 'forceDestroy'])->name('dataset.force-destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/get-data', [UserController::class, 'getData'])->name('users.get-data');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
// Route::get('/dataset', [DatasetController::class, 'index'])->name('dataset.index');
