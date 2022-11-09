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

    public function index()
    {
        $data = $this->userService->getAll();
        if (count($data) > 0) {
            $status = 'success';
        } else {
            $status = 'no-data';
        }

        $response = [
            'status' => $status,
            'data' => $data
        ];

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
    public function show($id)
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
    public function update(UserUpdateFormRequest $request, $id)
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
    public function destroy($id)
    {
        $user = $this->userService->getOne($id);
        if ($user) {
            $result = $this->userService->deleteUser($user);
            if ($result) {
                $response = [
                    'status' => 'success'
                ];
            } else {
                $response = [
                    'status' => 'error'
                ];
            }
        } else {
            $response = [
                'status' => 'error'
            ];
        }

        return $response;
    }
}