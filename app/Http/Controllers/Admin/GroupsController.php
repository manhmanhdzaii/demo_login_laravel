<?php

namespace App\Http\Controllers\Admin;

use App\Services\GroupService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Group\GroupFormRequest;

class GroupsController extends Controller
{
    protected $groupService;
    const PER_PAGE = 10;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Desc: Danh sách groups
     *
     */
    public function index(Request $request)
    {
        $lists = $this->groupService->getAll($request, self::PER_PAGE);
        return view('admin.groups.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm group
     *
     */
    public function add()
    {
        return view('admin.groups.add');
    }

    /**
     * Desc: Phương thức thêm group
     *
     */
    public function postAdd(GroupFormRequest $request)
    {
        $result = $this->groupService->createGroup($request);
        return redirect()->route('admin.groups.index')->with('msg', 'Thêm nhóm người dùng thành công');
    }

    /**
     * Desc: Giao diện sửa group
     *
     */
    public function edit(string $group)
    {
        $group = $this->groupService->getOne($group);
        if ($group) {
            return view('admin.groups.edit', compact('group'));
        }
        return redirect()->route('admin.groups.index')->with('err', 'Có lỗi xảy ra, không thể sửa thông tin nhóm người dùng này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin group
     *
     */
    public function postEdit(string $group, GroupFormRequest $request)
    {
        $group = $this->groupService->getOne($group);
        if ($group) {
            $result = $this->groupService->updateGroup($group, $request);
            return back()->with('msg', 'Cập nhật nhóm người dùng thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin nhóm người dùng này');
    }

    /**
     * Desc: Phương thức xóa group khỏi database
     *
     */
    public function delete(string $group)
    {
        $group = $this->groupService->getOne($group);
        if ($group) {
            $result = $this->groupService->deleteGroup($group);
            if ($result) {
                return redirect()->route('admin.groups.index')->with('msg', 'Xóa nhóm người dùng thành công');
            }
        }
        return redirect()->route('admin.groups.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin nhóm người dùng này');
    }

    /**
     * Desc: Giao diện phân quyền group
     *
     */
    public function permission(string $group)
    {
        $group = $this->groupService->getOne($group);
        if ($group) {
            $roleJson = $group->permissions;
            if (!empty($roleJson)) {
                $roleModule = json_decode($roleJson, true);
            } else {
                $roleModule = [];
            }
            $modules = getModules();
            $roleList = getRoleModule();
            return view('admin.groups.permission', compact('modules', 'roleList', 'group', 'roleModule'));
        }
        return redirect()->route('admin.groups.index')->with('err', 'Có lỗi xảy ra, không thể sửa thông tin nhóm người dùng này');
    }

    public function postPermission(string $group, Request $request)
    {
        $group = $this->groupService->getOne($group);
        if ($group) {
            if (!empty($request->role)) {
                $roleArr = $request->role;
            } else {
                $roleArr = [];
            }
            $roleJson = json_encode($roleArr);
            $result = $this->groupService->updateGroupPermission($group, $roleJson);
            if ($result) {
                return back()->with('msg', 'Phân quyền thành công');
            }
        }
        return redirect()->route('admin.groups.index')->with('err', 'Có lỗi xảy ra, không thể sửa phân quyền nhóm người dùng');
    }
}