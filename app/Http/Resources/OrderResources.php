<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type = getTypeOrder();
        $order_details = getProductOrder($this->id);
        $name_product = [];
        foreach ($order_details as $order_detail) {
            $name_product[] = $order_detail->product->name;
        }
        $name_order = implode(', ', $name_product);
        $sum_price = gettotalProductOrder($order_details);
        return [
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'type' => $type[$this->type],
            'name_order' => $name_order,
            'order_details' =>  $order_details,
            'sum_price' => $sum_price
        ];
    }
}