<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;

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
            'name.required' => "Tên danh mục sản phẩm không được để trống",
        ];
    }
}