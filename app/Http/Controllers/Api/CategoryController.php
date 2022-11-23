<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\Category\CategoryCreateFormRequest;
use App\Http\Requests\Category\CategoryUpdateFormRequest;

class CategoryController extends Controller
{
    protected $categoryService;
    const PER_PAGE = 10;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Desc: Phương thức lấy danh sách categories
     */
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"categories"},
     *     summary="Lấy danh sách categories",
     *     description="Lấy danh sách categories",
     *     operationId="indexCategory",
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
     *         description="Tên danh mục",
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
        $data = $this->categoryService->getAll($request, self::PER_PAGE);
        return [
            'status' => count($data) > 0 ? 'success' : 'no-data',
            'data' => $data,
        ];
    }

    /**
     * Desc: Phương thức thêm danh mục sản phẩm
     */
    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"categories"},
     *     summary="Tạo category",
     *     description="Tạo category",
     *     operationId="storeCategory",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="Category name",
     *                   type="string",
     *                   example="Mạnh"
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
     *                           "data": {
     *                            "name": "Mạnh",
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
     *                            "id": 37
     *                         }
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
    public function store(CategoryCreateFormRequest $request)
    {
        $result = $this->categoryService->createCategory($request);
        return [
            'status' => $result ? 'success' : 'error',
            'data' =>  $result,
        ];
    }

    /**
     * Desc: Phương thức lấy chi tiết danh mục sản phẩm
     */
    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     tags={"categories"},
     *     summary="Lấy chi tiết category",
     *     description="Lấy chi tiết category",
     *     operationId="showCategory",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="4"
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
     *                           "data": {
     *                            "id": 4,
     *                            "name": "Áo Nữ",
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
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
        $category = $this->categoryService->getOne($id);
        return [
            'status' => $category ? 'success' : 'error',
            'data' =>  $category,
        ];
    }

    /**
     * Desc: Phương thức update danh mục sản phẩm
     */
    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     tags={"categories"},
     *     summary="Update category",
     *     description="Update category",
     *     operationId="updateCategory",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id category",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1"
     *         )
     *     ),
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="User name",
     *                   type="string",
     *                   example="Mạnh"
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
     *                           "user": {
     *                            "id": 30,
     *                            "name": "Mạnh",
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
     *                         }
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
    public function update(CategoryUpdateFormRequest $request, string $id)
    {
        $category = $this->categoryService->getOne($id);
        if ($category) {
            $result = $this->categoryService->updateCategory($category, $request);
            $response = [
                'status' => 'success',
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 'no-data',
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức update danh mục sản phẩm
     */
    /**
     * @OA\Patch(
     *     path="/api/categories/{id}",
     *     tags={"categories"},
     *     summary="Update category",
     *     description="Update category",
     *     operationId="updatePatchCategory",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id category",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="30"
     *         )
     *     ),
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="name",
     *                   description="User name",
     *                   type="string",
     *                   example="Mạnh"
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
     *                           "data": {
     *                            "id": 30,
     *                            "name": "Mạnh",
     *                            "updated_at": "2022-11-21T04:25:14.000000Z",
     *                            "created_at": "2022-11-21T04:25:14.000000Z",
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *  ),
     * )
     */
    public function updatePatch(CategoryUpdateFormRequest $request, string $id)
    {
        $category = $this->categoryService->getOne($id);
        if ($category) {
            $result = $this->categoryService->updateCategory($category, $request);
            $response = [
                'status' => 'success',
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 'no-data',
            ];
        }
        return $response;
    }

    /**
     * Desc: Phương thức xóa danh mục sản phẩm
     */
    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     tags={"categories"},
     *     summary="Xóa category",
     *     description="Xóa category",
     *     operationId="destroyCategory",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id find",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="38"
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
        $category = $this->categoryService->getOne($id);
        if ($category) {
            $result = $this->categoryService->deleteCategory($category);
            return [
                'status' => $result ? 'success' : 'error',
            ];
        }
        return [
            'status' => 'error',
        ];
    }
}