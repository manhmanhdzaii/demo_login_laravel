<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\Category\CategoryCreateFormRequest;
use App\Http\Requests\Category\CategoryUpdateFormRequest;
use Laravel\Ui\Presets\React;

class CategoriesController extends Controller
{
    protected $categoryService;
    const PER_PAGE = 10;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Desc: Danh sách categories
     *
     */
    public function index(Request $request)
    {
        $lists = $this->categoryService->getAll($request, self::PER_PAGE);
        return view('admin.categories.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm category
     *
     */
    public function add()
    {
        return view('admin.categories.add');
    }

    /**
     * Desc: Phương thức thêm category, thêm người dùng vào base
     *
     */
    public function postAdd(CategoryCreateFormRequest $request)
    {
        $result = $this->categoryService->createCategory($request);
        return redirect()->route('admin.categories.index')->with('msg', 'Thêm nhóm sản phẩm thành công');
    }

    /**
     * Desc: Giao diện sửa category
     *
     */
    public function edit(string $category)
    {
        $category = $this->categoryService->getOne($category);
        if ($category) {
            return view('admin.categories.edit', compact('category'));
        }
        return redirect()->route('admin.categories.index')->with('err', 'Có lỗi xảy ra, không thể sửa thông tin danh mục này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin category trong database
     *
     */
    public function postEdit(string $category, CategoryUpdateFormRequest $request)
    {
        $category = $this->categoryService->getOne($category);
        if ($category) {
            $result = $this->categoryService->updateCategory($category, $request);
            return back()->with('msg', 'Cập nhật danh mục sản phẩm thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin danh mục sản phẩm này');
    }

    /**
     * Desc: Phương thức xóa category khỏi database
     *
     */
    public function delete(string $category)
    {
        $category = $this->categoryService->getOne($category);
        if ($category) {
            $result = $this->categoryService->deleteCategory($category);
            if ($result) {
                return redirect()->route('admin.categories.index')->with('msg', 'Xóa danh mục thành công');
            }
        }
        return redirect()->route('admin.categories.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin danh mục này');
    }
}