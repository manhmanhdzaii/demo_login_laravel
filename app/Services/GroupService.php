<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\GroupRepository;

class GroupService extends BaseService
{
    protected $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Desc: Phương thức lấy danh sách groups
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $list = $this->groupRepository->getAll($request, $per_page);
        return $list;
    }

    /**
     * Desc: Phương thức bản ghi group theo id
     *
     */
    public function getOne(string $id)
    {
        $list = $this->groupRepository->getOne($id);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới group
     *
     */
    public function createGroup(object $request)
    {
        $result = $this->groupRepository->createGroup($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin group
     *
     */
    public function updateGroup(object $group, object $request)
    {
        $result = $this->groupRepository->updateGroup($group, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa group
     *
     */
    public function deleteGroup(object $group)
    {
        $result = $this->groupRepository->deleteGroup($group);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin group permission
     *
     */
    public function updateGroupPermission(object $group, string $roleJson)
    {
        $result = $this->groupRepository->updateGroupPermission($group, $roleJson);
        return $result;
    }
}