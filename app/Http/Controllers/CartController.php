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

    /**
     * Desc: Danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $lists = $this->cartService->getAllOrders($request, self::PER_PAGE);
        return view('admin.orders.list', compact('lists'));
    }

    /**
     * Desc: Hiển thị chi tiết đơn hàng
     *
     */
    public function view(string $id)
    {
        $order = $this->cartService->getOneOrder($id);
        if ($order) {
            $lists = $this->cartService->getAllOrderDetails($id, self::PER_PAGE);
            return view('admin.orders.view', compact('lists'));
        }
        return redirect()->route('admin.orders.index')->with('err', 'Có lỗi xảy ra, không thể xem thông tin đơn hàng này');
    }

    /**
     * Desc: Phương thức xóa đơn hàng
     */
    public function delete(string $id)
    {
        $check = $this->cartService->getOneOrder($id);
        if ($check) {
            $result = $this->cartService->deleteOrder($id);
            return redirect()->route('admin.orders.index')->with('msg', 'Xóa đơn hàng thành công');
        }
        return redirect()->route('admin.orders.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin đơn hàng này');
    }

    /**
     * Desc: Phương thức thêm sản phẩm vào session Carts
     */
    public function addCart(Request $request)
    {
        return $this->cartService->addCart($request);
    }

    /**
     * Desc: Phương thức update session Carts
     */
    public function updateCart(Request $request)
    {
        return $this->cartService->updateCart($request);
    }

    /**
     * Desc: Phương thức thêm 1 sản phẩm từ bên ngoài vào session Carts
     */
    public function addOne(Request $request)
    {
        return $this->cartService->addOne($request);
    }

    /**
     * Desc: Phương thức checkout cart và add các thông tin về khách hàng và đơn hàng,chi tiết đơn hàng vào database
     */
    public function checkoutCart(Request $request)
    {
        return $this->cartService->checkoutCart($request);
    }

    /**
     * Desc: Phương thức update trạng thái đơn hàng
     */
    public function update_type_order(Request $request)
    {
        return $this->cartService->update_type_order($request);
    }
}