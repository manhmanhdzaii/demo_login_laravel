<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\Product\ProductCreateFormRequest;
use App\Http\Requests\Product\ProductUpdateFormRequest;

class ProductsController extends Controller
{
    protected $productService;
    const PER_PAGE = 10;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Desc: Danh sách products
     *
     */
    public function index(Request $request)
    {
        $lists = $this->productService->getAll($request, self::PER_PAGE);
        return view('admin.products.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm product
     *
     */
    public function add()
    {
        $categories = getCategories();
        $colors = getColors();
        $sizes = getSizes();
        return view('admin.products.add', compact('categories', 'colors', 'sizes'));
    }

    /**
     * Desc: Phương thức thêm product, thêm người dùng vào base
     *
     */
    public function postAdd(ProductCreateFormRequest $request)
    {
        $result = $this->productService->createProduct($request);
        return redirect()->route('admin.products.index')->with('msg', 'Thêm sản phẩm thành công');
    }

    /**
     * Desc: Giao diện sửa product
     *
     */
    public function edit(string $product)
    {
        $product = $this->productService->getOne($product);
        if ($product) {
            $categories = getCategories();
            $colors = getColors();
            $sizes = getSizes();
            $list_img = getListImg($product->id);
            return view('admin.products.edit', compact('product', 'colors', 'sizes', 'categories', 'list_img'));
        }
        return redirect()->route('admin.products.index')->with('err', 'Có lỗi xảy ra, không thể sửa thông tin sản phẩm này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin product trong database
     *
     */
    public function postEdit(string $product, ProductUpdateFormRequest $request)
    {
        $product = $this->productService->getOne($product);
        if ($product) {
            $result = $this->productService->updateProduct($product, $request);
            return back()->with('msg', 'Cập nhật sản phẩm thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin sản phẩm này');
    }

    /**
     * Desc: Phương thức xóa product khỏi database
     *
     */
    public function delete(string $product)
    {
        $product = $this->productService->getOne($product);
        if ($product) {
            $result = $this->productService->deleteProduct($product);
            return redirect()->route('admin.products.index')->with('msg', 'Xóa sản phẩm thành công');
        }
        return redirect()->route('admin.products.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin sản phẩm này');
    }
}