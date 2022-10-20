<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        if (Auth::user()->role == 'admin') {
            return RouteServiceProvider::ADMIN;
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(route('login'));
    }
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|string|email',
                'password' => 'required|string',
            ],
            [
                $this->username() . '.required' => 'Email đăng nhập không được để trống',
                $this->username() . '.string' => 'Kiểu dữ liệu đăng nhập không hợp lệ',
                $this->username() . '.email' => 'Email đăng nhập chưa đúng định dạng',
                'password.required' => 'Mật khẩu không được để trống',
                'password.string' => 'Kiểu dữ liệu đăng nhập không hợp lệ'
            ]
        );
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Tên đăng nhập hoặc mật khẩu không hợp lệ'],
        ]);
    }
}