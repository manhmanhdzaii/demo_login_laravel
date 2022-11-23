<?php

use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Img_Sub;
use App\Models\Products;
use App\Models\Order_Details;
use App\Models\Modules;
use App\Models\Groups;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;

function PerPage()
{
    return 10;
}
function getCategories()
{
    return Categories::get();
}
function getColors()
{
    return Colors::get();
}
function getModules()
{
    return Modules::get();
}
function getSizes()
{
    return Sizes::get();
}
function getGroups()
{
    return Groups::get();
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
function uploadImgInfo($file)
{
    $cre_time = time();
    $file_name = $file->getClientOriginalName();
    $file_name_array = explode('.', $file_name);
    $file_extension =  end($file_name_array);
    $path = 'upload/imginfo';
    if (!is_dir($path)) {
        mkdir($path, 0777, TRUE);
    }
    $name_upload = 'img_' . $cre_time  . '.' . $file_extension;
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
function getProductCartById($product_id)
{
    $products = Products::find($product_id);
    return $products;
}

function getTypeOrder()
{
    return [
        1 => "Chờ xác nhận",
        2 => "Đang lấy hàng",
        3 => "Đang giao hàng",
        4 => "Hoàn thành"
    ];
}

function getRoleModule()
{
    return [
        "view" => "Xem",
        "add" => "Thêm",
        "edit" => "Sửa",
        "delete" => "Xóa",
        "viewDetail" => "Xem chi tiết",
        "updateStatus" => "Cập nhật trạng thái",
        "permission" => "Phân quyền"
    ];
}

function getProductOrder($id)
{
    return Order_Details::where('order_id', $id)->get();
}

function gettotalProductOrder($orders)
{
    $total = 0;
    foreach ($orders as $order) {
        $price = $order->price * $order->amount;
        $total += $price;
    }
    return number_format($total);
}

function getToken($val)
{
    $hashToken = $val;
    $hashToken = str_replace('Bearer', '', $hashToken);
    $hashToken = trim($hashToken);
    $token = PersonalAccessToken::findToken($hashToken);
    return $token;
}
function isRole($dataArr, $module, $role = 'view')
{
    if (!empty($dataArr[$module])) {
        $roleArr = $dataArr[$module];
        if (in_array($role, $roleArr)) {
            return true;
        }
        return false;
    }
}