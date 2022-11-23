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
    const PER_PAGE = 9;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Desc: Phương thức lấy danh sách sản phẩm
     */
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"products"},
     *     summary="Lấy danh sách products",
     *     description="Lấy danh sách products",
     *     operationId="indexProduct",
     *  @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Phân trang",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             default="1"
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Tên sản phẩm",
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
    public function index(Request $request)
    {
        $data = $this->productService->getAll($request, self::PER_PAGE);
        return [
            'status' => count($data) > 0 ? 'success' : 'no-data',
            'data' => $data,
        ];
    }

    /**
     * Desc: Phương thức lấy chi tiết sản phẩm
     */
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"products"},
     *     summary="Lấy chi tiết Product",
     *     description="Lấy chi tiết Product",
     *     operationId="showProduct",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="10"
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
     *                       "status": "success",
     *                        "data": {
     *                           "id": 10,
     *                           "name": "Áo Unisex 1",
     *                           "price": 300,
     *                           "color_id": "1,2,3,4",
     *                           "size_id": "1,3,4",
     *                           "category_id": 5,
     *                           "img": "upload/img/img_251666578007.jpg",
     *                           "description": "<p>Lorem ipsum</p>",
     *                           "created_at": "2022-10-24T02:20:07.000000Z",
     *                           "updated_at": "2022-10-24T02:20:07.000000Z"
     *                        },
     *                        "imgs": {
     *                               {
     *                                   "id": 31,
     *                                   "path": "upload/img/10/img_1079410.jpg",
     *                                   "product_id": 10,
     *                                   "created_at": "2022-10-24T02:20:07.000000Z",
     *                                   "updated_at": "2022-10-24T02:20:07.000000Z"
     *                               },
     *                               {
     *                                   "id": 32,
     *                                   "path": "upload/img/10/img_395510.jpg",
     *                                   "product_id": 10,
     *                                   "created_at": "2022-10-24T02:20:07.000000Z",
     *                                   "updated_at": "2022-10-24T02:20:07.000000Z"
     *                               },
     *                               {
     *                                   "id": 33,
     *                                   "path": "upload/img/10/img_3641910.jpg",
     *                                   "product_id": 10,
     *                                   "created_at": "2022-10-24T02:20:07.000000Z",
     *                                   "updated_at": "2022-10-24T02:20:07.000000Z"
     *                               },
     *                               {
     *                                   "id": 34,
     *                                   "path": "upload/img/10/img_8871510.jpg",
     *                                   "product_id": 10,
     *                                   "created_at": "2022-10-24T02:20:08.000000Z",
     *                                   "updated_at": "2022-10-24T02:20:08.000000Z"
     *                               }
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    public function show(string $id)
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

    /**
     * Desc: Phương thức thêm sản phẩm
     */
    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"products"},
     *     summary="Tạo product",
     *     description="Tạo product",
     *     operationId="storeProduct",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="Product name",
     *                   type="string",
     *                   example="Mạnh"
     *               ),
     *               @OA\Property(
     *                   property="price",
     *                   description="Product price",
     *                   type="string",
     *                   example="400"
     *               ),
     *               @OA\Property(
     *                   property="category_id",
     *                   description="Product category",
     *                   type="string",
     *                   example="4"
     *               ),
     *               @OA\Property(
     *                   property="color_id",
     *                   description="Product color",
     *                   type="string",
     *                   enum={"1", "2", "3","4","5"},
     *               ),
     *               @OA\Property(
     *                   property="size_id",
     *                   description="Product size",
     *                   type="string",
     *                   enum={"1", "2", "3","4","5"},
     *               ),
     *               @OA\Property(
     *                   property="img",
     *                   description="Product img",
     *                   type="file",   
     *               ),
     *               @OA\Property(
     *                   property="img_sub[]",
     *                   description="Product img_sub",
     *                   type="file",   
     *               ),
     *               @OA\Property(
     *                   property="description",
     *                   description="Product description",
     *                   type="string",   
     *               ),
     *           )
     *       )
     *      ),
     *  @OA\Response(
     *         response="200",
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
     *  ),
     *  @OA\Response(
     *         response="422",
     *         description="Bad Request"
     *     ),
     * )
     */
    public function store(ProductCreateFormRequest $request)
    {
        $result = $this->productService->createProductApi($request);
        return [
            'status' => $result ? 'success' : 'error',
        ];
    }

    /**
     * Desc: Phương thức lấy số lượng sản phẩm theo danh mục
     */
    /**
     * @OA\Post(
     *     path="/api/products/getNumProducts",
     *     tags={"products"},
     *     summary="Lấy số lượng sản phẩm theo danh mục",
     *     description="Lấy số lượng sản phẩm theo danh mục",
     *     operationId="getNumProducts",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="category_id",
     *                   description="Id danh mục sản phẩm",
     *                   type="string",
     *                   example="3"
     *               ),
     *           )
     *       )
     *      ),
     *  @OA\Response(
     *         response="200",
     *         description="successful operation",
     *  ),
     *  @OA\Response(
     *         response="422",
     *         description="Bad Request"
     *     ),
     * )
     */
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

        return [
            'status' => count($data) > 0 ? 'success' : 'no-data',
            'data' => $data,
        ];
    }

    /**
     * Desc: Phương thức tìm kiếm sản phẩm
     */
    /**
     * @OA\Post(
     *     path="/api/products/search",
     *     tags={"products"},
     *     summary="Tìm kiếm product",
     *     description="Tìm kiếm product",
     *     operationId="search",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="color",
     *                   description="Màu sản phẩm",
     *                   type="string",
     *                   example="0"
     *               ),
     *               @OA\Property(
     *                   property="size",
     *                   description="Size sản phẩm",
     *                   type="string",
     *                   example="0"
     *               ),
     *               @OA\Property(
     *                   property="category",
     *                   description="Danh mục sản phẩm",
     *                   type="string",
     *                   example="0"
     *               ),
     *               @OA\Property(
     *                   property="search_price",
     *                   description="Tìm kiếm theo giá",
     *                   type="string",
     *                   example="0"
     *               ),
     *               @OA\Property(
     *                   property="price_min",
     *                   description="Giá nhỏ nhất",
     *                   type="string",
     *                   example="100"
     *               ),
     *               @OA\Property(
     *                   property="price_max",
     *                   description="Giá lớn nhất",
     *                   type="string",
     *                   example="900"
     *               ),
     *               @OA\Property(
     *                   property="list_sort_post",
     *                   description="Sắp xếp giá",
     *                   type="string",
     *                   example="0"
     *               ),
     *           )
     *       )
     *      ),
     *  @OA\Response(
     *         response="200",
     *         description="successful operation",
     *  ),
     *  @OA\Response(
     *         response="422",
     *         description="Bad Request"
     *     ),
     * )
     */
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
        return [
            'status' => count($data) > 0 ? 'success' : 'no-data',
            'data' => $data,
        ];
    }

    /**
     * Desc: Phương thức xóa sản phẩm
     */
    /**
     * Desc: Phương thức xóa danh mục sản phẩm
     */
    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"products"},
     *     summary="Xóa Product",
     *     description="Xóa Product",
     *     operationId="destroyProduct",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="100"
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
    public function destroy(string $product)
    {
        $product = $this->productService->getOne($product);
        if ($product) {
            $result = $this->productService->deleteProduct($product);
            return [
                'status' => $result ? 'success' : 'error'
            ];
        }
        return [
            'status' => 'error'
        ];
    }
}