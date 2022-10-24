<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashbroadController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

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

/**
 * Desc: Giao diện phía người dùng
 */

Route::get('/home', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/list-products', [HomeController::class, 'listProducts'])->name('listProducts');
Route::get('/detail-products/{idProduct}', [HomeController::class, 'detailProducts'])->name('detailProducts');
Route::get('/carts', [HomeController::class, 'carts'])->name('carts');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/home/logout', [HomeController::class, 'logout'])->name('home.logout');

/**
 * Desc: Giỏ hàng
 */
Route::post('/add-cart', [CartController::class, 'addCart'])->name('addCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('updateCart');

/**
 * Desc: Auth
 */
Auth::routes();

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

/**
 * Desc: Admin
 */
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

        Route::get('/edit/{productId}', [ProductsController::class, 'edit'])->name('edit');
        Route::post('/edit/{productId}', [ProductsController::class, 'postEdit']);

        Route::get('/delete/{productId}', [ProductsController::class, 'delete'])->name('delete');
    });
});

// Ajax
/**
 * Desc: Lấy danh sách sản phẩm theo danh mục ở trang chủ
 */
Route::post('/product_category', [HomeController::class, 'product_category']);

/**
 * Desc: Tìm kiếm ở trang danh sách sản phẩm
 */
Route::get('/search_list_products', [HomeController::class, 'search_list_products']);
/**
 * Desc: Thêm sản phầm vào giỏ hàng ở phía bên ngoài
 */
Route::post('/addOne', [CartController::class, 'addOne']);