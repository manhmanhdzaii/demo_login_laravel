<?php


namespace App\Http\Controllers\Admin;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserCreateFormRequest;
use App\Models\User;
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
        $lists = $this->userService->getAll();
        return view('admin.users.list', compact('lists'));
    }
    public function add()
    {
        return view('admin.users.add');
    }
    public function postAdd(UserCreateFormRequest $request)
    {
        $result = $this->userService->createUser($request);
        return redirect()->route('admin.users.index')->with('msg', 'Thêm người dùng thành công');
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function postEdit(User $user, UserUpdateFormRequest $request)
    {
        $result = $this->userService->updateUser($user, $request);
        return back()->with('msg', 'Cập nhật người dùng thành công');
    }
    public function delete(User $user)
    {
        $result = $this->userService->deleteUser($user);
        return redirect()->route('admin.users.index')->with('msg', 'Xóa người dùng thành công');
    }
}