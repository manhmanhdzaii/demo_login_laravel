<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\Product\ProductCreateFormRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;
    const PER_PAGE = 10;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $data = $this->productService->getAll($request, self::PER_PAGE);
        if (count($data) > 0) {
            $status = 'success';
        } else {
            $status = 'no-data';
        }

        $response = [
            'status' => $status,
            'data' => $data,
        ];

        return $response;
    }
    public function show($id)
    {
        $product = $this->productService->getOne($id);
        if ($product) {

            $categories = getCategories();
            $colors = getColors();
            $sizes = getSizes();
            $list_img = getListImg($product->id);
            $response = [
                'status' => 'success',
                'data' => $product,
                'categories' => $categories,
                'colors' => $colors,
                'sizes' => $sizes,
                'imgs' => $list_img,

            ];
        } else {
            $response = [
                'status' => 'no-data'
            ];
        }
        return $response;
    }
    public function store(ProductCreateFormRequest $request)
    {
        $result = $this->productService->createProductApi($request);
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

    public function getNumProducts(Request $request)
    {
        if ($request->category_id == 0) {
            $lists = getCategories();
            $category_id = $lists[0]->id;
            $data = getItemProduct($category_id, 4);
        } else if ($request->category_id < 0) {
            $data = getItemProduct(0, 8);
        } else {
            $data = getItemProduct($request->category_id, 4);
        }

        if (count($data) > 0) {
            $status = 'success';
        } else {
            $status = 'no-data';
        }

        $response = [
            'status' => $status,
            'data' => $data,
        ];

        return $response;
    }
    public function search(Request $request)
    {
        $category = $request->category;
        $color = $request->color;
        $size = $request->size;
        $list_sort_post = $request->list_sort_post;
        $search_price = $request->search_price;
        $price_min = $request->price_min;
        $price_max = $request->price_max;
        $data = $this->productService->searchListProducts($category, $color, $size, $list_sort_post, $search_price, $price_min, $price_max);
        if (count($data) > 0) {
            $status = 'success';
        } else {
            $status = 'no-data';
        }

        $response = [
            'status' => $status,
            'data' => $data,
        ];

        return $response;
    }
    public function destroy(string $product)
    {
        $product = $this->productService->getOne($product);
        if ($product) {
            $result = $this->productService->deleteProduct($product);
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
}