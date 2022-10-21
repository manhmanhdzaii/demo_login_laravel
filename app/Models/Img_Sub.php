<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Img_Sub extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'path'
    ];
    protected $table = 'img_sub';
}