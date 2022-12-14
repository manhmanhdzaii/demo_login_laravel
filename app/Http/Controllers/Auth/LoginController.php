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
                $this->username() . '.required' => 'Email ????ng nh???p kh??ng ???????c ????? tr???ng',
                $this->username() . '.string' => 'Ki???u d??? li???u ????ng nh???p kh??ng h???p l???',
                $this->username() . '.email' => 'Email ????ng nh???p ch??a ????ng ?????nh d???ng',
                'password.required' => 'M???t kh???u kh??ng ???????c ????? tr???ng',
                'password.string' => 'Ki???u d??? li???u ????ng nh???p kh??ng h???p l???'
            ]
        );
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['T??n ????ng nh???p ho???c m???t kh???u kh??ng h???p l???'],
        ]);
    }
}