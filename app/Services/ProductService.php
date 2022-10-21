<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\ProductRepository;

class ProductService extends BaseService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Desc: Phương thức lấy danh sách products
     *
     */
    public function getAll(object $request, string $per_page)
    {
        $list = $this->productRepository->getAll($request, $per_page);
        return $list;
    }

    /**
     * Desc: Phương thức bản ghi product theo id
     *
     */
    public function getOne(string $id)
    {
        $list = $this->productRepository->getOne($id);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới product
     *
     */
    public function createProduct(object $request)
    {
        $result = $this->productRepository->createProduct($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin product
     *
     */
    public function updateProduct(object $product, object $request)
    {
        $result = $this->productRepository->updateProduct($product, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa product
     *
     */
    public function deleteProduct(object $product)
    {
        $result = $this->productRepository->deleteProduct($product);
        return $result;
    }
}