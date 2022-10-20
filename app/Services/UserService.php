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
    public function getAll()
    {
        $list = $this->userRepository->getAll();
        return $list;
    }
    public function createUser($request)
    {
        $result = $this->userRepository->createUser($request);
        return $result;
    }
    public function updateUser($user, $request)
    {
        $result = $this->userRepository->updateUser($user, $request);
        return $result;
    }
    public function deleteUser($user)
    {
        $result = $this->userRepository->deleteUser($user);
        return $result;
    }
}