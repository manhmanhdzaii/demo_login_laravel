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

    /**
     * Desc: Phương thức lấy danh sách user
     *
     */
    public function getAll()
    {
        $lists = $this->user->get();
        return $lists;
    }

    /**
     * Desc: Phương thức bản ghi user theo id
     *
     */
    public function getOne(string $id)
    {
        $user = $this->user->find($id);
        return $user;
    }

    /**
     * Desc: Phương thức tạo mới user
     *
     */
    public function createUser(object $request)
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

    /**
     * Desc: Phương thức cập nhật thông tin user
     *
     */
    public function updateUser(object $user, object $request)
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

    /**
     * Desc: Phương thức xóa user
     *
     */
    public function deleteUser(object $user)
    {
        $this->user->destroy($user->id);
        return true;
    }
}