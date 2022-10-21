<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Products;
use App\Models\Img_Sub;

class ProductRepository extends BaseRepository
{
    protected $products;
    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * Desc: Phương thức lấy danh sách products
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $lists = $this->products;
        if (!empty($request->name)) {
            $lists = $lists->where('name', 'like', "%$request->name%");
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Phương thức bản ghi product theo id
     *
     */
    public function getOne(string $id)
    {
        $user = $this->products->find($id);
        return $user;
    }

    /**
     * Desc: Phương thức tạo mới product
     *
     */
    public function createProduct(object $request)
    {
        $products = new $this->products;

        $file = $request->file('img');

        $path_img = uploadImg($file);
        //add
        $products->name = $request->name;
        $products->price = $request->price;
        $products->color_id =  implode(',', $request->color_id);
        $products->size_id =  implode(',', $request->size_id);
        $products->category_id = $request->category_id;
        $products->img = $path_img;
        $products->description = $request->description;
        $products->save();
        $id = $products->id;

        $files = $request->file('img_sub');
        if (is_array($files) && count($files) > 0) {
            $length = count($files);
            for ($i = 0; $i < $length; $i++) {

                $path_up = uploadImg($files[$i], $id);

                Img_Sub::create([
                    'product_id' => $id,
                    'path' =>  $path_up,
                ]);
            }
        }

        return true;
    }

    /**
     * Desc: Phương thức cập nhật thông tin product
     *
     */
    public function updateProduct(object $product, object $request)
    {
        $cre_time = time();
        if ($request->file('img') != null) {

            $file = $request->file('img');
            $path_img = uploadImg($file);
            $product->img = $path_img;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->color_id =  implode(',', $request->color_id);
        $product->size_id =  implode(',', $request->size_id);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->save();

        if ($request->file('img_sub') != null) {
            $id = $product->id;
            Img_Sub::where('product_id', $id)->delete();
            $files = $request->file('img_sub');
            if (is_array($files) && count($files) > 0) {
                $length = count($files);
                for ($i = 0; $i < $length; $i++) {
                    $path_up = uploadImg($files[$i], $id);
                    Img_Sub::create([
                        'product_id' => $id,
                        'path' =>  $path_up,
                    ]);
                }
            }
        }
        return true;
    }

    /**
     * Desc: Phương thức xóa product
     *
     */
    public function deleteProduct(object $product)
    {
        $this->products->destroy($product->id);
        return true;
    }
}