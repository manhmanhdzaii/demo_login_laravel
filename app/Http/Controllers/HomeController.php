<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;

class HomeController extends Controller
{
    protected $productService;
    const PER_PAGE = 9;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Desc: Trang chủ
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Desc: Trang danh sách sản phẩm
     */
    public function listProducts(Request $request)
    {
        $lists = $this->productService->getAll($request, self::PER_PAGE);
        return view('list_products', compact('lists'));
    }

    /**
     * Desc: Trang chi tiết sản phẩm
     */
    public function detailProducts(string $id)
    {
        $product = $this->productService->getOne($id);
        if ($product) {
            return view('detail_product', compact('product'));
        }
        return redirect()->route('listProducts');
    }
    public function carts()
    {
        return view('carts');
    }
    public function checkout()
    {
        return view('checkout');
    }

    /**
     * Desc: Gọi ajax tới phương thức này để lấy danh sách sản phẩm theo danh mục ở trang chủ
     */
    public function product_category(Request $request)
    {
        $id = $request->category;
        $list = getItemProduct($id, 4);
        return $list;
    }

    /**
     * Desc: Gọi ajax tới phương thức này để thực hiện phần tìm kiếm ở trang danh sách sản phẩm
     */
    public function search_list_products(Request $request)
    {
        $category = $request->category;
        $color = $request->color;
        $size = $request->size;
        $list_sort_post = $request->list_sort_post;
        $search_price = $request->search_price;
        $price_min = $request->price_min;
        $price_max = $request->price_max;
        $lists = $this->productService->searchListProducts($category, $color, $size, $list_sort_post, $search_price, $price_min, $price_max);
        return $lists;
    }

    /**
     * Desc: Hàm logout ở phía người dùng vì không cần redirect
     */
    public function logout()
    {
        Auth::logout();
        return true;
    }
}