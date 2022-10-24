<?php

namespace App\Services;

use App\Services\BaseService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;

class CartService extends BaseService
{
    public function addCart(object $request)
    {
        $product_id = $request->product_id;
        $amount = $request->add_cart_value;
        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $amount,
            ]);
            return redirect()->route('carts');
        }
        $exists =  Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $amount;
            Session::put('carts',  $carts);
            return redirect()->route('carts');
        }
        $carts[$product_id] = $amount;
        Session::put('carts', $carts);
        return redirect()->route('carts');
    }
    public function updateCart(object $request)
    {
        Session::put('carts', $request->name_product);
        return redirect()->route('carts');
    }
    public function addOne(object $request)
    {
        $id = $request->id;
        $amount = 1;
        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $id => $amount,
            ]);
            return true;
        }
        $exists =  Arr::exists($carts, $id);
        if ($exists) {
            $carts[$id] = $carts[$id] + $amount;
            Session::put('carts',  $carts);
            return true;
        }
        $carts[$id] = $amount;
        Session::put('carts', $carts);
        return true;
    }
}