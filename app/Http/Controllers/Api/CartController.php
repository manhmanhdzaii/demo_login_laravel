<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCart;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Orders;
use App\Http\Resources\OrderResources;

class CartController extends Controller
{
    protected $cartService;
    const PER_PAGE = 10;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public  function index(Request $request)
    {
        $data = $this->cartService->getAllOrders($request, self::PER_PAGE);
        if (count($data) > 0) {
            $status = 'success';
        } else {
            $status = 'no-data';
        }
        $type = getTypeOrder();
        $response = [
            'status' => $status,
            'data' => $data,
            'type' => $type
        ];

        return $response;
    }
    public function show($id)
    {
        $order = $this->cartService->getOneOrder($id);
        if ($order) {
            $lists = $this->cartService->getAllOrderDetails($id, self::PER_PAGE);
            $response = [
                'status' => 'success',
                'data' => $lists
            ];
        } else {
            $response = [
                'status' => 'no-data'
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức update trạng thái đơn hàng
     */
    public function store(Request $request)
    {
        $result = $this->cartService->update_type_order($request);
        if ($result) {
            $response = [
                'status' => 'success',
            ];
        } else {
            $response = [
                'status' => 'error',
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức xóa đơn hàng
     */
    public function destroy(string $id)
    {
        $check = $this->cartService->getOneOrder($id);
        if ($check) {
            $result = $this->cartService->deleteOrder($id);
            if ($result) {
                $response = [
                    'status' => 'success'
                ];
            } else {
                $response = [
                    'status' => 'error'
                ];
            }
        } else {
            $response = [
                'status' => 'error'
            ];
        }

        return $response;
    }

    public function cart_session(Request $request)
    {
        $cart = $request->cart;
        $result = [];
        foreach ($cart as $value) {
            $id = $value['productId'];
            $product = getProductCartById($id);
            $product = new ProductCart($product, $value['qty']);
            $result[] = $product;
        }
        return $result;
    }

    public function checkout(Request $request)
    {

        $hashToken = $request->header('authorization');

        $hashToken = str_replace('Bearer', '', $hashToken);
        $hashToken = trim($hashToken);

        $token = PersonalAccessToken::findToken($hashToken);

        if ($token) {
            $data = $request->data;
            $cart = $request->cart;
            $this->cartService->addCartApi($token, $data, $cart);
            $response = [
                'status' => 200,
                'title' => 'Thêm sản phẩm vào giỏ hàng thành công'
            ];
        } else {
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }
        return $response;
    }

    public function orders(Request $request)
    {
        $hashToken = $request->header('authorization');

        $hashToken = str_replace('Bearer', '', $hashToken);
        $hashToken = trim($hashToken);

        $token = PersonalAccessToken::findToken($hashToken);
        if ($token) {
            $id = $token->tokenable_id;
            $list = Orders::where('user_id', $id)->get();
            if (count($list) > 0) {
                $result = [];
                foreach ($list as $order) {
                    $order = new OrderResources($order);
                    $result[] = $order;
                }
                $response = [
                    'status' => 'success',
                    'data' => $result
                ];
            } else {
                $response = [
                    'status' => 'no-data',
                ];
            }
        } else {
            $response = [
                'status' => 401,
                'title' => 'Unauthorized'
            ];
        }
        return $response;
    }

    public function colors()
    {
        $data = getColors();
        return $response = [
            'status' => 'success',
            'data' =>  $data,
        ];
    }
    public function sizes()
    {
        $data = getSizes();
        return $response = [
            'status' => 'success',
            'data' =>  $data,
        ];
    }
}