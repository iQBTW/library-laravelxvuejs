<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\CatalogController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PublisherController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('overview', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('catalog', [CatalogController::class, 'index'])->name('dashboard.catalog');

    Route::get('publisher', [PublisherController::class, 'index'])->name('dashboard.publisher');

    Route::get('author', [AuthorController::class, 'index'])->name('dashboard.author');

    Route::get('book', [BookController::class, 'index'])->name('dashboard.book');

    Route::get('member', [MemberController::class, 'index'])->name('dashboard.member');

});
