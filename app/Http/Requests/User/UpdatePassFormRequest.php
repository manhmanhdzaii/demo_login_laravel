<?php

namespace App\Http\Requests\User;

use App\Http\RequestS\BaseRequest;

class UpdatePassFormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rulesPost()
    {
        return [
            'password' => 'required',
            'new_password' => 'required|same:re_password',
        ];
    }
    public function messages()
    {
        return [
            'password.required' => "Mật khẩu cũ không được để trống",
            'new_password.required' => "Mật khẩu mới không được để trống",
            'new_password.same' => "Mật khẩu mới xác nhận không đúng",
        ];
    }
}