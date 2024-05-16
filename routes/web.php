<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\BookController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\CatalogController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PublisherController;
use App\Http\Controllers\Dashboard\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('authors', AuthorController::class);
Route::resource('publishers', PublisherController::class);
Route::resource('members', MemberController::class);
Route::resource('books', BookController::class);
Route::resource('users', UserController::class);
Route::resource('transactions', TransactionController::class);

Route::get('/api/publishers', [PublisherController::class, 'api']);
Route::get('/api/members', [MemberController::class, 'api']);
Route::get('/api/authors', [AuthorController::class, 'api']);
Route::get('/api/books', [BookController::class, 'api']);
Route::get('/api/transactions', [TransactionController::class, 'api']);

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('overview', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('catalog')->name('catalog.')->group(function () {
        Route::get('', [CatalogController::class, 'index'])->name('index');
        Route::get('create', [CatalogController::class, 'create'])->name('create');
        Route::post('store', [CatalogController::class, 'store'])->name('store');
    });

    // Route::prefix('publisher')->name('publisher.')->group(function (){
    //     Route::get('', [PublisherController::class, 'index'])->name('index');
    //     Route::get('create', [PublisherController::class, 'create'])->name('create');
    //     Route::post('store', [PublisherController::class, 'store'])->name('store');
    // });

    // Route::prefix('author')->name('author.')->group(function (){
    //     Route::get('', [AuthorController::class, 'index'])->name('index');
    //     Route::get('create', [AuthorController::class, 'create'])->name('create');
    //     Route::post('store', [AuthorController::class, 'store'])->name('store');
    // });

    // Route::prefix('book')->name('book.')->group(function () {
    //     Route::get('', [BookController::class, 'index'])->name('index');
    //     Route::get('create', [BookController::class, 'create'])->name('create');
    //     Route::post('store', [BookController::class, 'store'])->name('store');
    // });

    // Route::prefix('member')->name('member.')->group(function () {
    //     Route::get('', [MemberController::class, 'index'])->name('index');
    //     Route::get('create', [MemberController::class, 'create'])->name('create');
    //     Route::post('store', [MemberController::class, 'store'])->name('store');
    // });

    // Route::prefix('user')->name('user.')->group(function () {
    //     Route::get('', [UserController::class, 'index'])->name('index');
    //     Route::get('create', [UserController::class, 'create'])->name('create');
    //     Route::post('store', [UserController::class, 'store'])->name('store');
    // });

});
