<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        $lists = $this->user->get();
        return $lists;
    }
    public function createUser($request)
    {
        $user = new $this->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->email_verified_at = $request->email_verified_at == 1 ? date('Y-m-d H:i:s', time()) : NULL;
        $user->save();
        return true;
    }
    public function updateUser($user, $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->email_verified_at = $request->email_verified_at == 1 ? date('Y-m-d H:i:s', time()) : NULL;
        $user->save();
        return true;
    }
    public function deleteUser($user)
    {
        $this->user->destroy($user->id);
        return true;
    }
}