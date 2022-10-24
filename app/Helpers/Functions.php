<?php

use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Img_Sub;
use App\Models\Products;
use Illuminate\Support\Facades\Session;

function getCategories()
{
    return Categories::get();
}
function getColors()
{
    return Colors::get();
}
function getSizes()
{
    return Sizes::get();
}
function format_price($price)
{
    return number_format($price) . ' $';
}
function getListImg($id)
{
    return Img_Sub::where('product_id', $id)->get();
}

function getItemProduct($idCategory, $limit)
{
    if (!empty($idCategory)) {
        return Products::where('category_id', $idCategory)->limit($limit)->get();
    }
    return Products::limit($limit)->get();
}
function getSizeByString($str)
{
    $name = explode(',', $str);
    $name_arr = [];
    foreach ($name as $value) {
        $sizes = Sizes::where('id', $value)->first();
        $name_arr[] = $sizes->name;
    }
    return implode(', ', $name_arr);
}
function getColorByString($str)
{
    $name = explode(',', $str);
    $name_arr = [];
    foreach ($name as $value) {
        $sizes = Colors::where('id', $value)->first();
        $name_arr[] = $sizes->name;
    }
    return implode(', ', $name_arr);
}
function getNameCategory($id)
{
    $name = Categories::where('id', $id)->first();
    return $name->name;
}
function uploadImg($file, $id = '')
{
    $cre_time = time();
    $file_name = $file->getClientOriginalName();
    $file_name_array = explode('.', $file_name);
    $file_extension =  end($file_name_array);
    if (!empty($id)) {
        $path = 'upload/img/' . $id;
    } else {
        $path = 'upload/img';
    }
    if (!is_dir($path)) {
        mkdir($path, 0777, TRUE);
    }
    if (!empty($id)) {
        $name_upload = 'img_' . rand(0, 99999) . $id . '.' . $file_extension;
    } else {
        $name_upload = 'img_' . rand(0, 99) . $cre_time  . '.' . $file_extension;
    }
    $file->move($path, $name_upload);
    $path_img = $path . '/' . $name_upload;
    return $path_img;
}

function countCart()
{
    $carts = Session::get('carts');
    if (is_array($carts)) {
        return count($carts);
    }
    return 0;
}

function totalCart()
{
    $carts = Session::get('carts');
    if (is_array($carts)) {
        $product_id = array_keys($carts);
        $products = Products::whereIn('id', $product_id)->get();
        $total = 0;
        foreach ($products as $product) {
            $product_id = $product->id;
            $price = $product->price * $carts[$product_id];
            $total += $price;
        }
        return "$ " . number_format($total);
    }
    return "$ 0.00";
}

function getProductCart($carts)
{
    $product_id = array_keys($carts);
    $products = Products::whereIn('id', $product_id)->get();
    return $products;
}