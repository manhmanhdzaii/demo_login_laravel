<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use App\Http\Requests\Module\ModuleFormRequest;

class ModulesController extends Controller
{
    protected $moduleService;
    const PER_PAGE = 10;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    /**
     * Desc: Danh sách modules
     *
     */
    public function index(Request $request)
    {
        $lists = $this->moduleService->getAll($request, self::PER_PAGE);
        return view('admin.modules.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm module
     *
     */
    public function add()
    {
        $roleList = getRoleModule();
        return view('admin.modules.add', compact('roleList'));
    }

    /**
     * Desc: Phương thức thêm module
     *
     */
    public function postAdd(ModuleFormRequest $request)
    {
        $result = $this->moduleService->createModule($request);
        return redirect()->route('admin.modules.index')->with('msg', 'Thêm module thành công');
    }

    /**
     * Desc: Giao diện sửa module
     *
     */
    public function edit(string $module)
    {
        $module = $this->moduleService->getOne($module);
        if ($module) {
            $roleList = getRoleModule();
            return view('admin.modules.edit', compact('module', 'roleList'));
        }
        return redirect()->route('admin.modules.index')->with('err', 'Có lỗi xảy ra, không thể sửa thông tin module này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin module
     *
     */
    public function postEdit(string $module, ModuleFormRequest $request)
    {
        $module = $this->moduleService->getOne($module);
        if ($module) {
            $result = $this->moduleService->updateModule($module, $request);
            return back()->with('msg', 'Cập nhật module thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin module này');
    }

    /**
     * Desc: Phương thức xóa module khỏi database
     *
     */
    public function delete(string $module)
    {
        $module = $this->moduleService->getOne($module);
        if ($module) {
            $result = $this->moduleService->deleteModule($module);
            if ($result) {
                return redirect()->route('admin.modules.index')->with('msg', 'Xóa module thành công');
            }
        }
        return redirect()->route('admin.modules.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin module này');
    }
}