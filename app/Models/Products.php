<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Img_Sub;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }
    public function img_sub()
    {
        return $this->hasMany(Img_Sub::class, 'product_id', 'id');
    }
}