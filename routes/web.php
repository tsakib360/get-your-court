<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    return 'FINISHED';  
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

// Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/games/get/{id}', [HomeController::class, 'getGame']);
Route::get('/fields/get/{id}', [HomeController::class, 'getField']);

Route::get('/dashboard/books', [HomeController::class, 'userBooks'])->name('user.books');

Route::post('book', [HomeController::class, 'bookCourt'])->name('book.court');

Route::prefix('admin')->group(function () {
    Route::get('/register', function() {
        return view('adminauth.register');
    })->name('admin.register');
    Route::post('/register', [App\Http\Controllers\AdminAuth\RegisterController::class, 'create']);

    Route::get('/login', [App\Http\Controllers\AdminAuth\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\AdminAuth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\AdminAuth\LoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin'])->group(function() {
        Route::get('/home', function () {

            return view('admin.home');
        })->name('admin.home');

        Route::get('/area', [AdminController::class, 'createArea'])->name('area.create');
        Route::post('/area', [AdminController::class, 'storeArea']);
        Route::get('/game', [AdminController::class, 'createGame'])->name('game.create');
        Route::post('/game', [AdminController::class, 'storeGame']);
        Route::get('/games/get/{id}', [AdminController::class, 'getGame']);
        Route::get('/field', [AdminController::class, 'createField'])->name('field.create');
        Route::post('/field', [AdminController::class, 'storeField']);

        Route::get('/book/list', [AdminController::class, 'bookList'])->name('book.list');
        Route::get('/book/approve/{id}', [AdminController::class, 'bookApprove']);
        Route::get('/book/close/{id}', [AdminController::class, 'bookClose']);
    });
});
