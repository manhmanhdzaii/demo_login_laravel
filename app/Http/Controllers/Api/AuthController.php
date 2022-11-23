<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
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
    /**
     * @OA\Get(
     *     path="/api/infoUser",
     *     tags={"auth"},
     *     summary="Lấy thông tin user qua token",
     *     description="Lấy thông tin user qua token",
     *     security={{"sanctum":{}}},
     *     operationId="indexinfoUser",
     *  @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="Authorization",
     *      type="http",
     *      scheme="Bearer",
     *      bearerFormat="JWT",
     * ),
     *  @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                        "status": "success",
     *                        "data": {
     *                               "id": 3,
     *                               "name": "Phạm Doãn Mạnh",
     *                               "email": "manh@gmail.com",
     *                               "email_verified_at": "2022-11-23T06:15:21.000000Z",
     *                               "role": "admin",
     *                               "group_id": 5,
     *                               "created_at": null,
     *                               "updated_at": "2022-11-23T06:15:21.000000Z"
     *                          }
     *                     }
     *                 )
     *             )
     *         }
     *  ),
     *  @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     * )
     */
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
    /**
     * @OA\Put(
     *     path="/api/infoUser",
     *     tags={"auth"},
     *     summary="Cập nhật thông tin user qua token",
     *     description="Cập nhật thông tin user qua token",
     *     security={{"sanctum":{}}},
     *     operationId="updateinfoUser",
     *  @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="Authorization",
     *      type="http",
     *      scheme="Bearer",
     *      bearerFormat="JWT",
     * ),
     * @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="User name",
     *                   type="string",
     *                   example="Phạm Doãn Mạnh"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="manh@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="1"
     *               ),
     *               @OA\Property(
     *                   property="role",
     *                   description="User role",
     *                   type="string",
     *                   example="admin"
     *               ),
     *               @OA\Property(
     *                   property="email_verified_at",
     *                   description="User email_verified_at",
     *                   type="string",
     *                   example="1"
     *               ),
     *           )
     *       )
     *      ),
     *  @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                        "status": "success",
     *                        "data": {
     *                               "id": 3,
     *                               "name": "Phạm Doãn Mạnh",
     *                               "email": "manh@gmail.com",
     *                               "email_verified_at": "2022-11-23T06:15:21.000000Z",
     *                               "role": "admin",
     *                               "group_id": 5,
     *                               "created_at": null,
     *                               "updated_at": "2022-11-23T06:15:21.000000Z"
     *                          }
     *                     }
     *                 )
     *             )
     *         }
     *  ),
     *  @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     * )
     */
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
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"auth"},
     *     summary="Đăng nhập",
     *     description="Đăng nhập",
     *     operationId="login",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="manh@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="1"
     *               ),
     *           )
     *        )
     *  ),
     *  @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                         "status": "200",
     *                         "token" : "134|fIqxm9UiWBYG8ZhylxB8BbF6NUSxuRFvh8DMeBiu",
     *                         "name": "Phạm Doãn Mạnh"
     *                     }
     *                 )
     *             )
     *         }
     *  ),
     *  @OA\Response(
     *         response="422",
     *         description="Bad Request"
     *     ),
     * )
     */
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
                'title' => 'Email or Pass err'
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

    //Đăng ký
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"auth"},
     *     summary="Đăng ký",
     *     description="Đăng ký",
     *     operationId="register",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="User name",
     *                   type="string",
     *                   example="Mạnh1"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="manh111@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="12345678A"
     *               ),
     *           )
     *       )
     *      ),
     *  @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                         "status": "success",
     *                           "user": {
     *                            "name": "Mạnh1",
     *                            "email": "manh111@gmail.com",
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
     *                            "id": 30
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *  ),
     *  @OA\Response(
     *         response="422",
     *         description="Bad Request"
     *     ),
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là các ký tự',
            'email' => ':attribute không đúng định dạng email',
            'max' => ':attribute không được lớn hơn :max ký tự',
            'unique' => ':attribute đã được sử dụng',
            'min' => ':attribute phải lớn hơn :min ký tự'
        ]);

        $user =  User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
        ]);
        return [
            'status' => 'success',
            'user' =>  $user
        ];
    }
}