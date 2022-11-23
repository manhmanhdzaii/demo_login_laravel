<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashbroadController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\Admin\ModulesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\InfoController;

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

/**
 * Desc: Giao diện phía người dùng khi có auth
 */
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('/home/logout', [HomeController::class, 'logout'])->name('home.logout');

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index_home'])->name('index');
    Route::post('/', [UserController::class, 'update_info']);
    Route::get('/change_pass', [UserController::class, 'change_pass_home'])->name('change_pass');
    Route::post('/change_pass', [UserController::class, 'update_pass']);
    Route::get('/order', [UserController::class, 'user_order'])->name('order');
});


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
    Route::get('/myinfo', [DashbroadController::class, 'myInfo'])->name('myInfo');
    Route::post('/myinfo', [DashbroadController::class, 'postMyInfo']);
    Route::prefix('users')->name('users.')->middleware('can:users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');

        Route::get('/add', [UserController::class, 'add'])->name('add')->can('users.add');
        Route::post('/add', [UserController::class, 'postAdd']);

        Route::get('/edit/{userId}', [UserController::class, 'edit'])->name('edit')->can('users.edit');
        Route::post('/edit/{userId}', [UserController::class, 'postEdit']);

        Route::get('/delete/{userId}', [UserController::class, 'delete'])->name('delete')->can('users.delete');
    });
    Route::prefix('categories')->name('categories.')->middleware('can:categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');

        Route::get('/add', [CategoriesController::class, 'add'])->name('add')->can('categories.add');
        Route::post('/add', [CategoriesController::class, 'postAdd']);

        Route::get('/edit/{categoryId}', [CategoriesController::class, 'edit'])->name('edit')->can('categories.edit');
        Route::post('/edit/{categoryId}', [CategoriesController::class, 'postEdit']);
        Route::get('/delete/{categoryId}', [CategoriesController::class, 'delete'])->name('delete')->can('categories.delete');
    });
    Route::prefix('products')->name('products.')->middleware('can:products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('index');

        Route::get('/add', [ProductsController::class, 'add'])->name('add')->can('products.add');
        Route::post('/add', [ProductsController::class, 'postAdd']);

        Route::get('/edit/{productId}', [ProductsController::class, 'edit'])->name('edit')->can('products.edit');
        Route::post('/edit/{productId}', [ProductsController::class, 'postEdit']);

        Route::get('/delete/{productId}', [ProductsController::class, 'delete'])->name('delete')->can('products.delete');
    });
    Route::prefix('orders')->name('orders.')->middleware('can:orders')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/view/{orderId}', [CartController::class, 'view'])->name('view')->can('orders.viewDetail');
        Route::get('/delete/{orderId}', [CartController::class, 'delete'])->name('delete')->can('orders.delete');;
    });
    Route::prefix('info')->name('info.')->middleware('can:info')->group(function () {
        Route::prefix('contents')->name('contents.')->group(function () {
            Route::get('/', [InfoController::class, 'indexContents'])->name('index');

            Route::get('/add', [InfoController::class, 'addContents'])->name('add')->can('info.add');
            Route::post('/add', [InfoController::class, 'postAddContents']);

            Route::get('/edit/{contentId}', [InfoController::class, 'editContents'])->name('edit')->can('info.edit');
            Route::post('/edit/{contentId}', [InfoController::class, 'postEditContents']);

            Route::get('/delete/{contentId}', [InfoController::class, 'deleteContents'])->name('delete')->can('info.delete');
        });
        Route::prefix('imgs')->name('imgs.')->group(function () {
            Route::get('/', [InfoController::class, 'indexImgs'])->name('index');

            Route::get('/add', [InfoController::class, 'addImgs'])->name('add')->can('info.add');
            Route::post('/add', [InfoController::class, 'postAddImgs']);

            Route::get('/edit/{imgId}', [InfoController::class, 'editImgs'])->name('edit')->can('info.edit');
            Route::post('/edit/{imgId}', [InfoController::class, 'postEditImgs']);

            Route::get('/delete/{imgId}', [InfoController::class, 'deleteImgs'])->name('delete')->can('info.delete');
        });
    });
    Route::prefix('groups')->name('groups.')->middleware('can:groups')->group(function () {
        Route::get('/', [GroupsController::class, 'index'])->name('index');

        Route::get('/add', [GroupsController::class, 'add'])->name('add')->can('groups.add');
        Route::post('/add', [GroupsController::class, 'postAdd']);

        Route::get('/edit/{groupId}', [GroupsController::class, 'edit'])->name('edit')->can('groups.edit');
        Route::post('/edit/{groupId}', [GroupsController::class, 'postEdit']);

        Route::get('/delete/{groupId}', [GroupsController::class, 'delete'])->name('delete')->can('groups.delete');

        Route::get('/permission/{groupId}', [GroupsController::class, 'permission'])->name('permission')->can('groups.permission');;
        Route::post('/permission/{groupId}', [GroupsController::class, 'postPermission']);
    });
    Route::prefix('modules')->name('modules.')->middleware('can:modules')->group(function () {
        Route::get('/', [ModulesController::class, 'index'])->name('index');

        Route::get('/add', [ModulesController::class, 'add'])->name('add')->can('modules.add');
        Route::post('/add', [ModulesController::class, 'postAdd']);

        Route::get('/edit/{moduleId}', [ModulesController::class, 'edit'])->name('edit')->can('modules.edit');
        Route::post('/edit/{moduleId}', [ModulesController::class, 'postEdit']);

        Route::get('/delete/{moduleId}', [ModulesController::class, 'delete'])->name('delete')->can('modules.delete');;
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
/**
 * Desc: Checkout giỏ hàng
 */
Route::post('/checkoutCart', [CartController::class, 'checkoutCart']);
/**
 * Desc: Update trạng thái đơn hàng
 */
Route::post('/update_type_order', [CartController::class, 'update_type_order']);