<?php

namespace App\Http\Requests\Module;

use App\Http\Requests\BaseRequest;

class ModuleFormRequest extends BaseRequest
{
    public function rulesPost()
    {
        return [
            'name' => 'required',
            'title' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Tên module không được để trống",
            'title.required' => "Tiêu đề module không được để trống",
        ];
    }
}