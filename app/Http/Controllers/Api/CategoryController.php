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
    public function index(Request $request)
    {
        $data = $this->categoryService->getAll($request, self::PER_PAGE);
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

    public function store(CategoryCreateFormRequest $request)
    {
        $result = $this->categoryService->createCategory($request);
        if ($result) {
            $response = [
                'status' => 'success',
                'data' =>  $result,
            ];
        } else {
            $response = [
                'status' => 'error',
            ];
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryService->getOne($id);
        if ($category) {
            $response = [
                'status' => 'success',
                'data' => $category
            ];
        } else {
            $response = [
                'status' => 'no-data',
            ];
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateFormRequest $request, $id)
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
    public function destroy($id)
    {
        $category = $this->categoryService->getOne($id);
        if ($category) {
            $result = $this->categoryService->deleteCategory($category);
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