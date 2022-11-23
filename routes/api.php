<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('categories')->name('categories.')->group(function () {

    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');

    Route::post('/', [CategoryController::class, 'store'])->name('create');

    Route::put('/{category}', [CategoryController::class, 'update'])->name('update-put');

    Route::patch('/{category}', [CategoryController::class, 'updatePatch'])->name('update-patch');

    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('delete');
});
Route::prefix('products')->name('products.')->group(function () {

    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{products}', [ProductController::class, 'show'])->name('show');

    Route::post('/', [ProductController::class, 'store'])->name('create');

    Route::post('/getNumProducts', [ProductController::class, 'getNumProducts'])->name('getNumProducts');

    Route::post('/search', [ProductController::class, 'search']);

    // Route::patch('/{products}', [ProductController::class, 'update'])->name('update-patch');

    Route::delete('/{products}', [ProductController::class, 'destroy'])->name('delete');
});
Route::prefix('users')->name('users.')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');

    Route::post('/', [UserController::class, 'store'])->name('create');

    Route::put('/{user}', [UserController::class, 'update'])->name('update-put');

    Route::patch('/{user}', [UserController::class, 'updatePatch'])->name('update-patch');

    Route::delete('/{user}', [UserController::class, 'destroy'])->name('delete');
});
Route::prefix('ordersAdmin')->name('orders.')->group(function () {

    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/{id}', [CartController::class, 'show'])->name('show');

    Route::post('/', [CartController::class, 'store'])->name('create');

    // Route::put('/{user}', [UserController::class, 'update'])->name('update-put');

    // Route::patch('/{user}', [UserController::class, 'update'])->name('update-patch');

    Route::delete('/{id}', [CartController::class, 'destroy'])->name('delete');
});
Route::prefix('infoUser')->name('infoUser.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::put('/', [AuthController::class, 'update'])->name('update');
});

//Api login
Route::post('login', [AuthController::class, 'login']);

Route::get('token', [AuthController::class, 'getToken'])->middleware('auth:sanctum');

Route::post('refresh-token', [AuthController::class, 'refreshToken']);

//Api Register
Route::post('register', [AuthController::class, 'register']);

//Api getCart khi đang ở dạng sesion
Route::prefix('cart_session')->name('cart_session.')->group(function () {
    Route::post('/', [CartController::class, 'cart_session']);
    Route::post('checkout', [CartController::class, 'checkout'])->middleware('auth:sanctum');
});


//Order 
Route::get('orders', [CartController::class, 'orders']);

//Color,Size
Route::get('colors', [CartController::class, 'colors']);
Route::get('sizes', [CartController::class, 'sizes']);

//mật khẩu
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email'], [
        'email.required' => 'Địa chỉ email không được để trống',
        'email.email' => 'Địa chỉ email không đúng định dạng',
    ]);

    ResetPassword::createUrlUsing(function ($user, string $token) {
        return env('VUE_URL') . '/password/reset-password/' . $token . '?email=' . $user->email;
    });
    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        $response = [
            'status' =>  'success',
            'content' =>  __($status),
        ];
    } else {
        $response = [
            'status' =>  'err',
            'content' =>  __($status),
        ];
    }
    return $response;
});

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ], [
        'token.required' => 'Token không được để trống',
        'email.required' => 'Địa chỉ email không được để trống',
        'email.email' => 'Địa chỉ email không đúng định dạng',
        'password.required' => 'Mật khẩu không được để trống',
        'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        'password.min' => 'Mật khẩu phải từ :min ký tự',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return [
            'status' =>  'success',
            'content' =>  __($status),
        ];
    }
    return [
        'status' =>  'err',
        'content' =>  __($status),
    ];
});