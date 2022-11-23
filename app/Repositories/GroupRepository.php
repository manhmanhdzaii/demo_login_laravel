<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Groups;

class GroupRepository extends BaseRepository
{
    protected $groups;
    public function __construct(Groups $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Desc: Phương thức lấy danh sách groups
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $lists = $this->groups;
        if (!empty($request->name)) {
            $lists = $lists->where('name', 'like', "%$request->name%");
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Phương thức bản ghi group theo id
     *
     */
    public function getOne(string $id)
    {
        $group = $this->groups->find($id);
        return $group;
    }

    /**
     * Desc: Phương thức tạo mới group
     *
     */
    public function createGroup(object $request)
    {
        $group = new $this->groups;
        $group->name = $request->name;
        $group->save();
        return $group;
    }

    /**
     * Desc: Phương thức cập nhật thông tin group
     *
     */
    public function updateGroup(object $group, object $request)
    {
        $group->name = $request->name;
        $group->save();
        return $group;
    }

    /**
     * Desc: Phương thức xóa group
     *
     */
    public function deleteGroup(object $group)
    {
        $users = $group->users->count();
        if ($users > 0) {
            return false;
        }
        return $this->groups->destroy($group->id);
    }

    /**
     * Desc: Phương thức cập nhật thông tin group permission
     *
     */
    public function updateGroupPermission(object $group, string $roleJson)
    {
        $group->permissions = $roleJson;
        $group->save();
        return $group;
    }
}