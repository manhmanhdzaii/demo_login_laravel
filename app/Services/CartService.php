<?php

namespace App\Services;

use App\Services\BaseService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use App\Repositories\CartRepository;

class CartService extends BaseService
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Desc: Lấy danh sách đơn hàng
     */
    public function getAllOrders(object $request, string $per_page)
    {
        $list = $this->cartRepository->getAllOrders($request, $per_page);
        return $list;
    }

    /**
     * Desc: Find 1 đơn hàng theo id
     */
    public function getOneOrder(string $id)
    {
        $list = $this->cartRepository->getOneOrder($id);
        return $list;
    }

    /**
     * Desc: Lấy chi tiết đơn hàng
     *
     */
    public function getAllOrderDetails(string $id, string $per_page)
    {
        $list = $this->cartRepository->getAllOrderDetails($id, $per_page);
        return $list;
    }

    /**
     * Desc: Xóa đơn hàng
     *
     */
    public function deleteOrder(string $id)
    {
        $result = $this->cartRepository->deleteOrder($id);
        return $result;
    }

    /**
     * Desc: Phương thức thêm sản phẩm vào session Carts
     */
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

    /**
     * Desc: Phương thức update session Carts
     */
    public function updateCart(object $request)
    {
        Session::put('carts', $request->name_product);
        return redirect()->route('carts');
    }

    /**
     * Desc: Phương thức thêm 1 sản phẩm từ bên ngoài vào session Carts
     */
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

    /**
     * Desc: Phương thức checkout cart và add các thông tin về khách hàng và đơn hàng,chi tiết đơn hàng vào database
     */
    public function checkoutCart(object $request)
    {
        $result = $this->cartRepository->checkoutCart($request);
        return $result;
    }

    /**
     * Desc: Phương thức update trạng thái đơn hàng
     */
    public function update_type_order(object $request)
    {
        $result = $this->cartRepository->update_type_order($request);
        return $result;
    }

    public function addCartApi($token, $data, $cart)
    {
        $result = $this->cartRepository->addCartApi($token, $data, $cart);
        return $result;
    }
}