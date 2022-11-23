<?php

namespace App\Http\Requests\Group;

use App\Http\Requests\BaseRequest;

class GroupFormRequest extends BaseRequest
{
    public function rulesPost()
    {
        return [
            'name' => 'required',
        ];
    }
    public function rulesPut()
    {
        return [
            'name' => 'required',
        ];
    }
    public function rulesPatch()
    {
        return [
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Tên nhóm người dùng không được để trống",
        ];
    }
}