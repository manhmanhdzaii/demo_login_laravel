<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Info;

class InfoRepository extends BaseRepository
{
    protected $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }

    /**
     * Desc: Phương thức lấy danh sách infoContents
     *
     */
    public function getContents(object $request, string $per_page)
    {
        $lists = $this->info->where('type', 1);
        if (!empty($request->name)) {
            $lists = $lists->where('title', 'like', "%$request->name%");
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Phương thức bản ghi infoContents theo id
     *
     */
    public function getOne(string $id)
    {
        $info = $this->info->find($id);
        return $info;
    }

    /**
     * Desc: Phương thức tạo mới infoContents
     *
     */
    public function createinfoContents(object $request)
    {
        $info = new $this->info;
        $info->title = $request->title;
        $info->type = 1;
        $info->content = $request->content;
        $info->save();
        return $info;
    }

    /**
     * Desc: Phương thức cập nhật thông tin infoContents
     *
     */
    public function updateinfoContents(object $info, object $request)
    {
        $info->title = $request->title;
        $info->content = $request->content;
        $info->save();
        return $info;
    }

    /**
     * Desc: Phương thức xóa infoContents
     *
     */
    public function deleteinfoContents(object $info)
    {

        return $this->info->destroy($info->id);
    }

    /**
     * Desc: Phương thức lấy danh sách infoImgs
     *
     */
    public function getImgs(object $request, string $per_page)
    {
        $lists = $this->info->where('type', 2);
        if (!empty($request->name)) {
            $lists = $lists->where('title', 'like', "%$request->name%");
        }
        $lists = $lists->paginate($per_page)->withQueryString();
        return $lists;
    }

    /**
     * Desc: Phương thức tạo mới infoImgs
     *
     */
    public function createinfoImgs(object $request)
    {
        $img = $request->file('path');
        $path_img = uploadImgInfo($img);

        $info = new $this->info;
        $info->title = $request->title;
        $info->type = 2;
        $info->path = $path_img;
        $info->save();
        return $info;
    }

    /**
     * Desc: Phương thức cập nhật thông tin infoImgs
     *
     */
    public function updateinfoImgs(object $info, object $request)
    {
        $info->title = $request->title;
        if ($request->file('path') != null) {
            $img = $request->file('path');
            $path_img = uploadImgInfo($img);
            $info->path = $path_img;
        }
        $info->save();
        return $info;
    }

    /**
     * Desc: Phương thức xóa infoImgs
     *
     */
    public function deleteinfoImgs(object $info)
    {

        return $this->info->destroy($info->id);
    }
}