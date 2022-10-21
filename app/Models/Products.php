<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }
}