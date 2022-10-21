<?php

namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use App\Http\Controllers\Controller;
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
     * Desc: Danh sách user
     *
     */
    public function index()
    {
        $lists = $this->userService->getAll();
        return view('admin.users.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm user
     *
     */
    public function add()
    {
        return view('admin.users.add');
    }

    /**
     * Desc: Phương thức thêm user, thêm người dùng vào base
     *
     */
    public function postAdd(UserCreateFormRequest $request)
    {
        $result = $this->userService->createUser($request);
        return redirect()->route('admin.users.index')->with('msg', 'Thêm người dùng thành công');
    }

    /**
     * Desc: Giao diện sửa user
     *
     */
    public function edit(string $user)
    {
        $user = $this->userService->getOne($user);
        if ($user) {
            return view('admin.users.edit', compact('user'));
        }
        return redirect()->route('admin.users.index')->with('err', 'Có lỗi xảy ra, không thể sửa thông tin người dùng này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin user trong database
     *
     */
    public function postEdit(string $user, UserUpdateFormRequest $request)
    {
        $user = $this->userService->getOne($user);
        if ($user) {
            $result = $this->userService->updateUser($user, $request);
            return back()->with('msg', 'Cập nhật người dùng thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin người dùng này');
    }

    /**
     * Desc: Phương thức xóa user khỏi database
     *
     */
    public function delete(string $user)
    {
        $user = $this->userService->getOne($user);
        if ($user) {
            $result = $this->userService->deleteUser($user);
            return redirect()->route('admin.users.index')->with('msg', 'Xóa người dùng thành công');
        }
        return redirect()->route('admin.users.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin người dùng này');
    }
}