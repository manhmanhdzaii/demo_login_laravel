<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashbroadController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('home.logout');
Route::get('/list-products', [App\Http\Controllers\HomeController::class, 'listProducts'])->name('listProducts');
Route::get('/detail-products', [App\Http\Controllers\HomeController::class, 'detailProducts'])->name('detailProducts');
Route::get('/carts', [App\Http\Controllers\HomeController::class, 'carts'])->name('carts');
Route::get('/checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [DashbroadController::class, 'index'])->name('index');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');

        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/add', [UserController::class, 'postAdd']);

        Route::get('/edit/{userId}', [UserController::class, 'edit'])->name('edit');
        Route::post('/edit/{userId}', [UserController::class, 'postEdit']);

        Route::get('/delete/{userId}', [UserController::class, 'delete'])->name('delete');
    });
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');

        Route::get('/add', [CategoriesController::class, 'add'])->name('add');
        Route::post('/add', [CategoriesController::class, 'postAdd']);

        Route::get('/edit/{categoryId}', [CategoriesController::class, 'edit'])->name('edit');
        Route::post('/edit/{categoryId}', [CategoriesController::class, 'postEdit']);

        Route::get('/delete/{categoryId}', [CategoriesController::class, 'delete'])->name('delete');
    });
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('index');

        Route::get('/add', [ProductsController::class, 'add'])->name('add');
        Route::post('/add', [ProductsController::class, 'postAdd']);

        Route::get('/edit/{categoryId}', [ProductsController::class, 'edit'])->name('edit');
        Route::post('/edit/{categoryId}', [ProductsController::class, 'postEdit']);

        Route::get('/delete/{categoryId}', [ProductsController::class, 'delete'])->name('delete');
    });
});