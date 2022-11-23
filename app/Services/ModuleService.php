<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\ModuleRepository;

class ModuleService extends BaseService
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Desc: Phương thức lấy danh sách modules
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $list = $this->moduleRepository->getAll($request, $per_page);
        return $list;
    }

    /**
     * Desc: Phương thức bản ghi module theo id
     *
     */
    public function getOne(string $id)
    {
        $list = $this->moduleRepository->getOne($id);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới module
     *
     */
    public function createModule(object $request)
    {
        $result = $this->moduleRepository->createModule($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin module
     *
     */
    public function updateModule(object $module, object $request)
    {
        $result = $this->moduleRepository->updateModule($module, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa module
     *
     */
    public function deleteModule(object $module)
    {
        $result = $this->moduleRepository->deleteModule($module);
        return $result;
    }
}