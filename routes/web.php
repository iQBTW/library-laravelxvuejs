<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('overview', [DashboardController::class, 'index'])->name('dashboard');
});
