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
    public function store(CategoryCreateFormRequest $request)
    {
        $result = $this->categoryService->createCategory($request);
        return [
            'status' => $result ? 'success' : 'error',
            'data' =>  $result,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức lấy chi tiết danh mục sản phẩm
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức update danh mục sản phẩm
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Desc: Phương thức xóa danh mục sản phẩm
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