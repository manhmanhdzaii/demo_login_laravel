<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class ProductUpdateFormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rulesPost()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'color_id' => 'required',
            'size_id' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => ":attribute không được để trống",
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm',
            'color_id' => 'Màu sản phẩm',
            'size_id' => 'Cỡ sản phẩm',
            'category_id' => 'Danh mục sản phẩm',
            'description' => 'Chi tiết sản phẩm',
        ];
    }
}