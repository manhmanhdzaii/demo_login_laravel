<?php

use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Img_Sub;

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