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

    /**
     * Desc: Phương thức lấy danh sách đơn hàng
     */
    /**
     * @OA\Get(
     *     path="/api/ordersAdmin",
     *     tags={"orders"},
     *     summary="Lấy danh sách đơn hàng",
     *     description="Lấy danh sách đơn hàng",
     *     operationId="indexOrder",
     *  @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Tên người mua",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             default=""
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * )
     */
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

    /**
     * Desc: Phương thức lấy chi tiết đơn hàng
     */
    /**
     * @OA\Get(
     *     path="/api/ordersAdmin/{id}",
     *     tags={"orders"},
     *     summary="Lấy chi tiết đơn hàng",
     *     description="Lấy chi tiết đơn hàng",
     *     operationId="indexdelailtOrder",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Chi tiết đơn hàng",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             default="9"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                        "status": "success",
     *                         "data": {
     *                               "current_page": 1,
     *                               "data": {
     *                                   {
     *                                       "id": 11,
     *                                       "order_id": 9,
     *                                       "product_id": 6,
     *                                       "amount": 1,
     *                                       "price": 250,
     *                                       "created_at": "2022-10-25T10:26:43.000000Z",
     *                                       "updated_at": "2022-10-25T10:26:43.000000Z",
     *                                       "product": {
     *                                           "id": 6,
     *                                           "name": "Áo Nam 1",
     *                                           "price": 250,
     *                                           "color_id": "1,2,3,4,5",
     *                                           "size_id": "1,2,3,4,5",
     *                                           "category_id": 3,
     *                                           "img": "upload/img/img_311666577684.jpg",
     *                                           "description": "<p>&Aacute;o Nam đẹp</p>",
     *                                           "created_at": "2022-10-24T02:14:44.000000Z",
     *                                           "updated_at": "2022-10-24T02:14:44.000000Z"
     *                                       }
     *                                   },
     *                                   {
     *                                       "id": 12,
     *                                       "order_id": 9,
     *                                       "product_id": 7,
     *                                       "amount": 2,
     *                                       "price": 300,
     *                                       "created_at": "2022-10-25T10:26:43.000000Z",
     *                                       "updated_at": "2022-10-25T10:26:43.000000Z",
     *                                       "product": {
     *                                           "id": 7,
     *                                           "name": "Áo Nữ 1",
     *                                           "price": 300,
     *                                           "color_id": "2,3",
     *                                           "size_id": "2,3,4",
     *                                           "category_id": 4,
     *                                           "img": "upload/img/img_921666577776.jpg",
     *                                           "description": "<p>Lorem ispsum</p>",
     *                                           "created_at": "2022-10-24T02:16:16.000000Z",
     *                                           "updated_at": "2022-10-24T02:16:16.000000Z"
     *                                       }
     *                                   },
     *                                   {
     *                                       "id": 13,
     *                                       "order_id": 9,
     *                                       "product_id": 8,
     *                                       "amount": 1,
     *                                       "price": 700,
     *                                       "created_at": "2022-10-25T10:26:43.000000Z",
     *                                       "updated_at": "2022-10-25T10:26:43.000000Z",
     *                                       "product": {
     *                                           "id": 8,
     *                                           "name": "Áo Nam 2",
     *                                           "price": 700,
     *                                           "color_id": "1,2,4",
     *                                           "size_id": "1,3,4",
     *                                           "category_id": 3,
     *                                           "img": "upload/img/img_941666577871.jpg",
     *                                           "description": "<p>Lorem ipsum</p>",
     *                                           "created_at": "2022-10-24T02:17:51.000000Z",
     *                                           "updated_at": "2022-10-24T02:17:51.000000Z"
     *                                       }
     *                                   }
     *                               },
     *                               "first_page_url": "http://127.0.0.1:8000/api/ordersAdmin/9?page=1",
     *                               "from": 1,
     *                               "last_page": 1,
     *                               "last_page_url": "http://127.0.0.1:8000/api/ordersAdmin/9?page=1",
     *                               "links": {
     *                                   {
     *                                       "url": null,
     *                                       "label": "&laquo; Previous",
     *                                       "active": false
     *                                   },
     *                                   {
     *                                       "url": "http://127.0.0.1:8000/api/ordersAdmin/9?page=1",
     *                                       "label": "1",
     *                                       "active": true
     *                                   },
     *                                   {
     *                                       "url": null,
     *                                       "label": "Next &raquo;",
     *                                       "active": false
     *                                   }
     *                               },
     *                               "next_page_url": null,
     *                               "path": "http://127.0.0.1:8000/api/ordersAdmin/9",
     *                               "per_page": 10,
     *                               "prev_page_url": null,
     *                               "to": 3,
     *                               "total": 3
     *                           }
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    public function show(string $id)
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
    /**
     * @OA\Post(
     *     path="/api/ordersAdmin",
     *     tags={"orders"},
     *     summary="Update trạng thái đơn hàng",
     *     description="Update trạng thái đơn hàng",
     *     operationId="updateTypeOrder",
     *  @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="order",
     *                   description="Id đơn hàng",
     *                   type="string",
     *                   example="9"
     *               ),
     *               @OA\Property(
     *                   property="type",
     *                   description="Trạng thái đơn hàng",
     *                   type="string",
     *                   example="2"
     *               ),
     *           )
     *       )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                         "status": "success",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Bad Request"
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $result = $this->cartService->update_type_order($request);

        return [
            'status' => $result ? 'success' : 'error',
        ];
    }

    /**
     * Desc: Phương thức xóa đơn hàng
     */
    /**
     * @OA\Delete(
     *     path="/api/ordersAdmin/{id}",
     *     tags={"orders"},
     *     summary="Xóa đơn hàng",
     *     description="Xóa đơn hàng",
     *     operationId="destroyOrders",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     example={
     *                         "status": "success",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    public function destroy(string $id)
    {
        $check = $this->cartService->getOneOrder($id);
        if ($check) {
            $result = $this->cartService->deleteOrder($id);
            return [
                'status' => $result ? 'success' : 'error',
            ];
        }

        return [
            'status' => 'error',
        ];
    }

    /**
     * Desc: Phương thức lấy danh sách sản phẩm từ session cart
     */
    public function cart_session(Request $request)
    {
        $cart = $request->cart;
        if (!$cart) {
            return "no-data";
        }
        $result = [];
        foreach ($cart as $value) {
            $id = $value['productId'];
            $product = getProductCartById($id);
            $product = new ProductCart($product, $value['qty']);
            $result[] = $product;
        }
        return $result;
    }

    /**
     * Desc: Phương thức checkout cart
     */
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

    /**
     * Desc: Phương thức lấy danh sách order theo id
     */
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

    /**
     * Desc: Phương thức lấy danh sách màu
     */
    public function colors()
    {
        $data = getColors();
        return $response = [
            'status' => 'success',
            'data' =>  $data,
        ];
    }

    /**
     * Desc: Phương thức lấy danh sách size
     */
    public function sizes()
    {
        $data = getSizes();
        return $response = [
            'status' => 'success',
            'data' =>  $data,
        ];
    }
}