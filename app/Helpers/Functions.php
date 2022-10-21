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