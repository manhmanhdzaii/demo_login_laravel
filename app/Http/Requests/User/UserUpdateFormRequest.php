<?php

namespace App\Http\Requests\User;

use App\Http\RequestS\BaseRequest;

class UserUpdateFormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rulesPost()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'email_verified_at' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "Tên không được để trống",
            'email.required' => "Email không được để trống",
            'email.email' => "Email không đúng định dạng",
            'role.required' => "Chức vụ không được để trống",
            'email_verified_at.required' => "Kích hoạt tài khoản không được để trống",
        ];
    }
}