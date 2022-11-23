<?php

namespace App\Http\Requests\Info;

use App\Http\Requests\BaseRequest;

class InfoImgCreateFormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rulesPost()
    {
        return [
            'title' => 'required',
            'path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "Tiêu đề không được để trống",
            'path.required' => "Nội dung không được để trống",
        ];
    }
}