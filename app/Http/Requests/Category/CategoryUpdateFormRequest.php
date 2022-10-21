<?php

namespace App\Http\Requests\Category;

use App\Http\RequestS\BaseRequest;

class CategoryUpdateFormRequest extends BaseRequest
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Tên danh mục sản phẩm không được để trống",
        ];
    }
}