<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;


class CartController extends Controller
{
    protected $cartService;
    const PER_PAGE = 10;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index(Request $request)
    {
        $lists = $this->cartService->getAllOrders($request, self::PER_PAGE);
        return view('admin.orders.list', compact('lists'));
    }
    public function view(string $id)
    {
        $order = $this->cartService->getOneOrder($id);
        if ($order) {
            $lists = $this->cartService->getAllOrderDetails($id, self::PER_PAGE);
            return view('admin.orders.view', compact('lists'));
        }
        return redirect()->route('admin.orders.index')->with('err', 'Có lỗi xảy ra, không thể xem thông tin đơn hàng này');
    }

    public function delete(string $id)
    {
        $check = $this->cartService->getOneOrder($id);
        if ($check) {
            $result = $this->cartService->deleteOrder($id);
            return redirect()->route('admin.orders.index')->with('msg', 'Xóa đơn hàng thành công');
        }
        return redirect()->route('admin.orders.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin đơn hàng này');
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
    public function checkoutCart(Request $request)
    {
        return $this->cartService->checkoutCart($request);
    }
}