<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * Desc: Phương thức lấy danh sách user
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức thêm user
     */
    public function store(UserCreateFormRequest $request)
    {


        $result = $this->userService->createUser($request);
        if ($result) {
            $response = [
                'status' => 'success',
                'category' =>  $result,
            ];
        } else {
            $response = [
                'status' => 'error',
            ];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức lấy chi tiết user
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức cập nhật user
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức xóa user
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