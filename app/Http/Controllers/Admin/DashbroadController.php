<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class DashbroadController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Desc: Giao diện admin sau khi đăng nhập
     *
     */
    public function index()
    {
        return view('admin.dashbroad');
    }

    /**
     * Desc: Giao diện thông tin cá nhân
     *
     */
    public function myInfo()
    {
        $user = Auth::user();
        return view('admin.myinfo', compact('user'));
    }
    /**
     * Desc: Cập nhật thông tin cá nhân
     *
     */
    public function postMyInfo(Request $request)
    {
        $user = Auth::user();

        $result = $this->userService->updateUser($user, $request);
        if ($result) {
            return back()->with('msg', 'Cập nhật thông tin cá nhân thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin cá nhân');
    }
}