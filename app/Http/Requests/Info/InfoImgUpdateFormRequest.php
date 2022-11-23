<?php

namespace App\Http\Requests\Info;

use App\Http\Requests\BaseRequest;

class InfoImgUpdateFormRequest extends BaseRequest
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
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "Tiêu đề không được để trống",
        ];
    }
}