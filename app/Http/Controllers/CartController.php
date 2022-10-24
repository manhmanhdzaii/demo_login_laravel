<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;


class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addCart(Request $request)
    {
        return $this->cartService->addCart($request);
    }
    public function updateCart(Request $request)
    {
        return $this->cartService->updateCart($request);
    }
    public function addOne(Request $request)
    {
        return $this->cartService->addOne($request);
    }
}