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

    /**
     * Desc: Phương thức cập nhật thông tin user
     */
    public function update_info(object $request)
    {
        $result = $this->userRepository->update_info($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật mật khẩu user
     */
    public function update_pass(object $request)
    {
        $result = $this->userRepository->update_pass($request);
        return $result;
    }

    /**
     * Desc: Phương thức lấy danh sách đơn hàng user
     */
    public function user_order()
    {
        $result = $this->userRepository->user_order();
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật Api patch user
     *
     */
    public function ApiUpdateUserPatch(object $user, object $request)
    {
        $result = $this->userRepository->ApiUpdateUserPatch($user, $request);
        return $result;
    }
}