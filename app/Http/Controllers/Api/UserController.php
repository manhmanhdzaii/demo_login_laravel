<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\User\UserCreateFormRequest;
use App\Http\Requests\User\UserUpdateFormRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Desc: Phương thức lấy danh sách users
     */
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"users"},
     *     summary="Lấy danh sách users",
     *     description="Lấy danh sách users",
     *     operationId="index",
     *  @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Phân trang",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             default="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * )
     */
    public function index()
    {
        $data = $this->userService->getAll();
        return [
            'status' => count($data) > 0 ? 'success' : 'no-data',
            'data' => $data,
        ];
    }

    /**
     * Desc: Phương thức thêm user
     */
    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"users"},
     *     summary="Tạo user",
     *     description="Tạo user",
     *     operationId="store",
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
     *                   example="Mạnh"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="manh1@gmail.com"
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
     *                   example="nomal"
     *               ),
     *               @OA\Property(
     *                   property="email_verified_at",
     *                   description="User email_verified_at",
     *                   type="string",
     *                   example="0"
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
     *                            "name": "Mạnh",
     *                            "email": "manh1@gmail.com",
     *                            "role": "nomal",
     *                            "email_verified_at": null,
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
    public function store(UserCreateFormRequest $request)
    {
        $result = $this->userService->createUser($request);
        if ($result) {
            $response = [
                'status' => 'success',
                'user' =>  $result,
            ];
        } else {
            $response = [
                'status' => 'error',
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức lấy chi tiết user
     */
    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Lấy chi tiết user",
     *     description="Lấy chi tiết user",
     *     operationId="show",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                         "status": "success",
     *                           "user": {
     *                            "id": 30,
     *                            "name": "Mạnh",
     *                            "email": "manh1@gmail.com",
     *                            "role": "nomal",
     *                            "email_verified_at": null,
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    public function show(string $id)
    {
        $user = $this->userService->getOne($id);
        if ($user) {
            $response = [
                'status' => 'success',
                'data' => $user
            ];
        } else {
            $response = [
                'status' => 'no-data',
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức cập nhật user
     */
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Update user",
     *     description="Update user",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="30"
     *         )
     *     ),
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
     *                   example="Mạnh"
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
     *                   example="1"
     *               ),
     *               @OA\Property(
     *                   property="role",
     *                   description="User role",
     *                   type="string",
     *                   example="nomal"
     *               ),
     *               @OA\Property(
     *                   property="email_verified_at",
     *                   description="User email_verified_at",
     *                   type="string",
     *                   example="0"
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
     *                            "id": 30,
     *                            "name": "Mạnh",
     *                            "email": "manh111@gmail.com",
     *                            "role": "nomal",
     *                            "email_verified_at": null,
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
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
    public function update(UserUpdateFormRequest $request, string $id)
    {
        $user = $this->userService->getOne($id);
        if ($user) {
            $methob = $request->method();
            if ($methob == 'PUT') {
                $result = $this->userService->updateUser($user, $request);
                $response = [
                    'status' => 'success',
                    'data' => $result
                ];
            } else {
                $result = $this->userService->ApiUpdateUserPatch($user, $request);
                $response = [
                    'status' => 'success',
                    'data' => $result
                ];
            }
        } else {
            $response = [
                'status' => 'no-data',
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức cập nhật user Patch
     */
    /**
     * @OA\Patch(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Update user",
     *     description="Update user",
     *     operationId="updatePatch",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="30"
     *         )
     *     ),
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
     *                   example="Mạnh"
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
     *                   example="1"
     *               ),
     *               @OA\Property(
     *                   property="role",
     *                   description="User role",
     *                   type="string",
     *                   example="nomal"
     *               ),
     *               @OA\Property(
     *                   property="email_verified_at",
     *                   description="User email_verified_at",
     *                   type="string",
     *                   example="0"
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
     *                            "id": 30,
     *                            "name": "Mạnh",
     *                            "email": "manh111@gmail.com",
     *                            "role": "nomal",
     *                            "email_verified_at": null,
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *  ),
     * )
     */
    public function updatePatch(UserUpdateFormRequest $request, string $id)
    {
        $user = $this->userService->getOne($id);
        if ($user) {
            $result = $this->userService->ApiUpdateUserPatch($user, $request);
            $response = [
                'status' => 'success',
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 'no-data',
            ];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức xóa user
     */
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Xóa user",
     *     description="Xóa user",
     *     operationId="destroy",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="29"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                         "status": "success",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    public function destroy(string $id)
    {
        $user = $this->userService->getOne($id);
        if ($user) {
            $result = $this->userService->deleteUser($user);
            return [
                'status' => $result ? 'success' : 'error',
            ];
        }
        return [
            'status' => 'error',
        ];
    }
}