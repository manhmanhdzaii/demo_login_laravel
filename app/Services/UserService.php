<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Desc: Phương thức lấy danh sách user
     *
     */
    public function getAll()
    {
        $list = $this->userRepository->getAll();
        return $list;
    }

    /**
     * Desc: Phương thức bản ghi user theo id
     *
     */
    public function getOne(string $id)
    {
        $list = $this->userRepository->getOne($id);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới user
     *
     */
    public function createUser(object $request)
    {
        $result = $this->userRepository->createUser($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin user
     *
     */
    public function updateUser(object $user, object $request)
    {
        $result = $this->userRepository->updateUser($user, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa user
     *
     */
    public function deleteUser(object $user)
    {
        $result = $this->userRepository->deleteUser($user);
        return $result;
    }
}