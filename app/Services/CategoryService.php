<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Desc: Phương thức lấy danh sách categories
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $list = $this->categoryRepository->getAll($request, $per_page);
        return $list;
    }

    /**
     * Desc: Phương thức bản ghi category theo id
     *
     */
    public function getOne(string $id)
    {
        $list = $this->categoryRepository->getOne($id);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới category
     *
     */
    public function createCategory(object $request)
    {
        $result = $this->categoryRepository->createCategory($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin category
     *
     */
    public function updateCategory(object $category, object $request)
    {
        $result = $this->categoryRepository->updateCategory($category, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa category
     *
     */
    public function deleteCategory(object $category)
    {
        $result = $this->categoryRepository->deleteCategory($category);
        return $result;
    }
}