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
        $lists = $this->products->with('category');
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
        if ($id) {
            $files = $request->file('img_sub');
            if (is_array($files) && count($files) > 0) {
                $length = count($files);
                for ($i = 0; $i < $length; $i++) {

                    $path_up = uploadImg($files[$i], $id);

                    // Img_Sub::create([
                    //     'product_id' => $id,
                    //     'path' =>  $path_up,
                    // ]);
                    $products->img_sub()->create([
                        'product_id' => $id,
                        'path' =>  $path_up,
                    ]);
                }
            }
            return true;
        }

        return false;
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

    /**
     * Desc: Phương thức Tìm kiếm danh sách sản phẩm
     *
     */
    public function searchListProducts(string $category, string $color, string $size, string $list_sort_post, string $search_price, string $price_min, string $price_max)
    {
        $list = $this->products;
        if ($category != 0) {
            $list =  $list->where('category_id', $category);
        }
        if ($color != 0) {
            $list = $list->whereRaw('FIND_IN_SET ("' . $color . '" , color_id) > 0');
        }
        if ($size != 0) {
            $list = $list->whereRaw('FIND_IN_SET ("' . $size . '" , size_id) > 0');
        }
        if ($search_price != 0) {
            $list =  $list->where('price', ">=", $price_min)->where('price', "<=", $price_max);
        }
        if ($list_sort_post != 0) {
            if ($list_sort_post == 2) {
                $list =  $list->orderByDesc('price');
            } else {
                $list =  $list->orderBy('price');
            }
        }
        $list =  $list->paginate(9);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới product
     *
     */
    public function createProductApi(object $request)
    {
        $products = new $this->products;

        $file = $request->file('img');

        $path_img = uploadImg($file);
        //add
        $products->name = $request->name;
        $products->price = $request->price;
        $products->color_id =  $request->color_id;
        $products->size_id =  $request->size_id;
        $products->category_id = $request->category_id;
        $products->img = $path_img;
        $products->description = $request->description;
        $products->save();
        $id = $products->id;
        if ($id) {
            $files = $request->file('img_sub');
            if (is_array($files) && count($files) > 0) {
                $length = count($files);
                for ($i = 0; $i < $length; $i++) {

                    $path_up = uploadImg($files[$i], $id);

                    // Img_Sub::create([
                    //     'product_id' => $id,
                    //     'path' =>  $path_up,
                    // ]);
                    $products->img_sub()->create([
                        'product_id' => $id,
                        'path' =>  $path_up,
                    ]);
                }
            }
            return true;
        }

        return false;
    }
}