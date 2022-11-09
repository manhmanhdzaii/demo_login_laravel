<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCart extends JsonResource
{
    protected $qty;
    public function __construct($resource, $qty)
    {
        parent::__construct($resource);
        $this->qty = $qty;
    }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img,
            'price' => $this->price,
            'qty' => $this->qty,
        ];
    }
}