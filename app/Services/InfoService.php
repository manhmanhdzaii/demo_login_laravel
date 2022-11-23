<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\InfoRepository;

class InfoService extends BaseService
{
    protected $infoRepository;

    public function __construct(InfoRepository $infoRepository)
    {
        $this->infoRepository = $infoRepository;
    }

    /**
     * Desc: Phương thức lấy danh sách infoContents
     *
     */
    public function getContents(object $request, string $per_page)
    {
        $list = $this->infoRepository->getContents($request, $per_page);
        return $list;
    }
    /**
     * Desc: Phương thức lấy 1 bản ghi info
     *
     */
    public function getOne(string $id)
    {
        $list = $this->infoRepository->getOne($id);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới infoContents
     *
     */
    public function createinfoContents(object $request)
    {
        $result = $this->infoRepository->createinfoContents($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin infoContents
     *
     */
    public function updateinfoContents(object $info, object $request)
    {
        $result = $this->infoRepository->updateinfoContents($info, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa infoContents
     *
     */
    public function deleteinfoContents(object $info)
    {
        $result = $this->infoRepository->deleteinfoContents($info);
        return $result;
    }

    /**
     * Desc: Phương thức lấy danh sách infoImgs 
     *
     */
    public function getImgs(object $request, string $per_page)
    {
        $list = $this->infoRepository->getImgs($request, $per_page);
        return $list;
    }

    /**
     * Desc: Phương thức tạo mới infoImgs 
     *
     */
    public function createinfoImgs(object $request)
    {
        $result = $this->infoRepository->createinfoImgs($request);
        return $result;
    }

    /**
     * Desc: Phương thức cập nhật thông tin infoImgs 
     *
     */
    public function updateinfoImgs(object $info, object $request)
    {
        $result = $this->infoRepository->updateinfoImgs($info, $request);
        return $result;
    }

    /**
     * Desc: Phương thức xóa infoImgs 
     *
     */
    public function deleteinfoImgs(object $info)
    {
        $result = $this->infoRepository->deleteinfoImgs($info);
        return $result;
    }
}