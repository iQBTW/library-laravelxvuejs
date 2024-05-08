<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\CatalogController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PublisherController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('overview', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('catalog')->name('catalog.')->group(function (){
        Route::get('', [CatalogController::class, 'index'])->name('index');
        Route::get('create', [CatalogController::class, 'create'])->name('create');
        Route::post('store', [CatalogController::class, 'store'])->name('store');
    });

    Route::prefix('publisher')->name('publisher.')->group(function (){
        Route::get('', [PublisherController::class, 'index'])->name('index');
        Route::get('create', [PublisherController::class, 'create'])->name('create');
        Route::post('store', [PublisherController::class, 'store'])->name('store');
    });

    Route::get('author', [AuthorController::class, 'index'])->name('dashboard.author');

    Route::get('book', [BookController::class, 'index'])->name('dashboard.book');

    Route::get('member', [MemberController::class, 'index'])->name('dashboard.member');

});
