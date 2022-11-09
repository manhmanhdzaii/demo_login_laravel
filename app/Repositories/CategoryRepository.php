<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Categories;

class CategoryRepository extends BaseRepository
{
    protected $categories;
    public function __construct(Categories $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Desc: Phương thức lấy danh sách categories
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $lists = $this->categories;
        if (!empty($request->name)) {
            $lists = $lists->where('name', 'like', "%$request->name%");
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Phương thức bản ghi category theo id
     *
     */
    public function getOne(string $id)
    {
        $user = $this->categories->find($id);
        return $user;
    }

    /**
     * Desc: Phương thức tạo mới category
     *
     */
    public function createCategory(object $request)
    {
        $category = new $this->categories;
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    /**
     * Desc: Phương thức cập nhật thông tin category
     *
     */
    public function updateCategory(object $category, object $request)
    {
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    /**
     * Desc: Phương thức xóa category
     *
     */
    public function deleteCategory(object $category)
    {

        return $this->categories->destroy($category->id);
    }
}