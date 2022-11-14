<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use App\Services\UserService;
use App\Http\Requests\User\UserUpdateFormRequest;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //lấy thông tin user bằng token
    public function index(Request $request)
    {
        $token = getToken($request->header('authorization'));
        if ($token) {
            $id = $token->tokenable_id;
            $user = $this->userService->getOne($id);
            $response = [
                'status' => 'success',
                'data' => $user
            ];
        } else {
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }
        return $response;
    }
    //update user
    public function update(UserUpdateFormRequest $request)
    {
        $token = getToken($request->header('authorization'));
        if ($token) {
            $id = $token->tokenable_id;
            $user = $this->userService->getOne($id);
            $result = $this->userService->updateUser($user, $request);
            $response = [
                'status' => 'success',
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }
        return $response;
    }
    //login kèm tạo mã thông báo
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $checkLogin =  Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if ($checkLogin) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'status' => 200,
                'token' => $token,
                'name' => $user->name,
            ];
        } else {
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }

        return $response;
    }

    //thu hồi mã  thông báo
    public function token(Request $request)
    {
        // $user = User::find(3);
        // $tokens = $user->tokens;


        // return $user->tokens()->delete();

        return $request->user()->currentAccessToken()->delete();
    }

    //tạo mới mã thông báo khi hết hạn
    public function refreshToken(Request $request)
    {
        if ($request->header('authorization')) {
            $hashToken = $request->header('authorization');

            $hashToken = str_replace('Bearer', '', $hashToken);
            $hashToken = trim($hashToken);

            $token = PersonalAccessToken::findToken($hashToken);
            if ($token) {

                $tokenCreate = $token->create_at;
                $expire = Carbon::parse($tokenCreate)->addMinutes(config('sanctum.expiration'));

                if (Carbon::now() >= $expire) {
                    $userId = $token->tokenable_id;
                    $user = User::find($userId);
                    $user->tokens()->delete();

                    $newToken = $user->createToken('auth_token')->plainTextToken;
                    $response = [
                        'status' => 200,
                        'token' => $newToken
                    ];
                } else {
                    $response = [
                        'status' => 200,
                        'token' => 'Unexpires'
                    ];
                }
            } else {
                $response = [
                    'status' => 401,
                    'title' => 'Unauthorized'
                ];
            }
            return $response;
        }
    }
}