<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}