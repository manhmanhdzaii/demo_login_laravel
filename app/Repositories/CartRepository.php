<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Order_Details;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Auth;

class CartRepository extends BaseRepository
{
    protected $customers;
    protected $orders;
    protected $order_details;
    public function __construct(Customers $customers, Orders $orders, Order_Details $order_details)
    {
        $this->customers = $customers;
        $this->orders = $orders;
        $this->order_details = $order_details;
    }

    /**
     * Desc: Lấy danh sách đơn hàng
     */
    public function getAllOrders(object $request, string $per_page)
    {
        $lists = $this->orders->with('customer');
        if (!empty($request->name)) {
            $name = $request->name;
            $lists = $lists->orWhereHas('customer', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Find 1 đơn hàng theo id
     */
    public function getOneOrder(string $id)
    {
        $order = $this->orders->find($id);
        return $order;
    }

    /**
     * Desc: Lấy chi tiết đơn hàng
     */
    public function getAllOrderDetails(string $id, string $per_page)
    {

        $lists = $this->order_details->with('product')->where('order_id', $id);
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Xóa đơn hàng
     *
     */
    public function deleteOrder(string $id)
    {
        $this->orders->destroy($id);
        return true;
    }

    /**
     * Desc: Phương thức checkout cart và add các thông tin về khách hàng và đơn hàng,chi tiết đơn hàng vào database
     */
    public function checkoutCart(object $request)
    {

        //Create Customers
        $customers = $this->customers;
        $customers->name = $request->name;
        $customers->phone = $request->phone;
        $customers->email = $request->email;
        $customers->city = $request->city;
        $customers->note = $request->note;
        $customers->save();

        //Create Orders 
        $customer_id = $customers->id;
        $code = md5(uniqid(rand(), true));
        $orders = $this->orders;
        $orders->code = $code;
        $orders->customer_id = $customer_id;
        $orders->user_id = Auth::user()->id;
        $orders->type = 1;
        $orders->save();

        // Create Order_Details
        $order_id = $orders->id;
        $carts = Session::get('carts');
        $products = getProductCart($carts);
        foreach ($products as $product) {
            $product_id = $product->id;
            $amount = $carts[$product_id];
            $price = $product->price;
            Order_Details::create([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'amount' => $amount,
                'price' => $price,
            ]);
        }
        Session::put('carts', []);

        $job = (new SendMail($request->email));
        dispatch($job);
        return true;
    }

    /**
     * Desc: Phương thức update trạng thái đơn hàng
     */
    public function update_type_order(object $request)
    {
        $order_id = $request->order;
        $type = $request->type;
        $order =  $this->orders->find($order_id);
        if ($order) {
            $order->type = $type;
            $order->save();
            return true;
        }
        return false;
    }

    public function addCartApi($token, $data, $cart)
    {
        //create cus
        $customer = $this->customers;
        $customer->name = $data['name'];
        $customer->phone = $data['phone'];
        $customer->email = $data['email'];
        $customer->city = $data['city'];
        $customer->note = $data['note'];
        $customer->save();

        //Create Orders 
        $orders = $this->orders;
        $customer_id = $customer->id;
        $code = md5(uniqid(rand(), true));
        $orders->code = $code;
        $orders->customer_id = $customer_id;
        //lấy user_từ token

        $orders->user_id = $token->tokenable_id;
        $orders->type = 1;
        $orders->save();

        $order_id = $orders->id;
        foreach ($cart as $value) {
            $id = $value['productId'];
            $product = getProductCartById($id);
            Order_Details::create([
                'order_id' => $order_id,
                'product_id' => $product->id,
                'amount' => $value['qty'],
                'price' => $product->price,
            ]);
        }
    }
}