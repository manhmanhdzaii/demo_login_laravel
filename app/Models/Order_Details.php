<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_Details extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id', 'amount', 'price'
    ];
    protected $table = 'order_details';

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}