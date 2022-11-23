<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Modules;

class ModuleRepository extends BaseRepository
{
    protected $modules;
    public function __construct(Modules $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Desc: Phương thức lấy danh sách modules
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $lists = $this->modules;
        if (!empty($request->name)) {
            $lists = $lists->where('name', 'like', "%$request->name%");
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Phương thức bản ghi module theo id
     *
     */
    public function getOne(string $id)
    {
        $module = $this->modules->find($id);
        return $module;
    }

    /**
     * Desc: Phương thức tạo mới module
     *
     */
    public function createModule(object $request)
    {
        $module = new $this->modules;
        $module->name = $request->name;
        $module->title = $request->title;
        $module->role = implode(',', $request->role);
        $module->save();
        return $module;
    }

    /**
     * Desc: Phương thức cập nhật thông tin module
     *
     */
    public function updateModule(object $module, object $request)
    {
        $module->name = $request->name;
        $module->title = $request->title;
        $module->role = implode(',', $request->role);
        $module->save();
        return $module;
    }

    /**
     * Desc: Phương thức xóa module
     *
     */
    public function deleteModule(object $module)
    {
        return $this->modules->destroy($module->id);
    }
}