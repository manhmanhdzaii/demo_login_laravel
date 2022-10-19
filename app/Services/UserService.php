<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepositsory = $userRepository;
    }
    public function index()
    {
        return "aaaaaaaaaaa";
    }
}