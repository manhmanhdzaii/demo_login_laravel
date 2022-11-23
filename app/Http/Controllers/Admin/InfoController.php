<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InfoService;
use App\Http\Requests\Info\InfoContentFormRequest;
use App\Http\Requests\Info\InfoImgCreateFormRequest;
use App\Http\Requests\Info\InfoImgUpdateFormRequest;

class InfoController extends Controller
{
    protected $infoService;
    const PER_PAGE = 10;

    public function __construct(InfoService $infoService)
    {
        $this->infoService = $infoService;
    }

    /**
     * Desc: Danh sách infoContents
     *
     */
    public function indexContents(Request $request)
    {
        $lists = $this->infoService->getContents($request, self::PER_PAGE);
        return view('admin.info.contents.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm infoContents
     *
     */
    public function addContents()
    {
        return view('admin.info.contents.add');
    }

    /**
     * Desc: Phương thức thêm infoContents
     *
     */
    public function postAddContents(InfoContentFormRequest $request)
    {
        $result = $this->infoService->createinfoContents($request);
        return redirect()->route('admin.info.contents.index')->with('msg', 'Thêm thông tin thành công');
    }

    /**
     * Desc: Giao diện sửa infoContents
     *
     */
    public function editContents(string $content)
    {
        $info = $this->infoService->getOne($content);
        if ($info) {
            return view('admin.info.contents.edit', compact('info'));
        }
        return redirect()->route('admin.info.contents.index')->with('err', 'Có lỗi xảy ra, không thể sửa mục thông tin này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin infoContents
     *
     */
    public function postEditContents(string $content, InfoContentFormRequest $request)
    {
        $content = $this->infoService->getOne($content);
        if ($content) {
            $result = $this->infoService->updateinfoContents($content, $request);
            return back()->with('msg', 'Cập nhật thông tin thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin này');
    }

    /**
     * Desc: Phương thức xóa infoContents khỏi database
     *
     */
    public function deleteContents(string $content)
    {
        $content = $this->infoService->getOne($content);
        if ($content) {
            $result = $this->infoService->deleteinfoContents($content);
            return redirect()->route('admin.info.contents.index')->with('msg', 'Xóa danh mục thành công');
        }
        return redirect()->route('admin.info.contents.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin danh mục này');
    }

    /**
     * Desc: Danh sách infoImgs
     *
     */
    public function indexImgs(Request $request)
    {
        $lists = $this->infoService->getImgs($request, self::PER_PAGE);
        return view('admin.info.imgs.list', compact('lists'));
    }

    /**
     * Desc: Giao diện thêm infoImgs
     *
     */
    public function addImgs()
    {
        return view('admin.info.imgs.add');
    }

    /**
     * Desc: Phương thức thêm infoImgs
     *
     */
    public function postAddImgs(InfoImgCreateFormRequest $request)
    {
        $result = $this->infoService->createinfoImgs($request);
        return redirect()->route('admin.info.imgs.index')->with('msg', 'Thêm thông tin thành công');
    }

    /**
     * Desc: Giao diện sửa infoImgs
     *
     */
    public function editImgs(string $img)
    {
        $info = $this->infoService->getOne($img);
        if ($info) {
            return view('admin.info.imgs.edit', compact('info'));
        }
        return redirect()->route('admin.info.imgs.index')->with('err', 'Có lỗi xảy ra, không thể sửa mục thông tin này');
    }

    /**
     * Desc: Phương thức cập nhật thông tin infoImgs
     *
     */
    public function postEditImgs(string $img, InfoImgUpdateFormRequest $request)
    {
        $img = $this->infoService->getOne($img);
        if ($img) {
            $result = $this->infoService->updateinfoImgs($img, $request);
            return back()->with('msg', 'Cập nhật thông tin thành công');
        }
        return back()->with('err', 'Có lỗi xảy ra, không thể cập nhật thông tin này');
    }

    /**
     * Desc: Phương thức xóa infoImgs khỏi database
     *
     */
    public function deleteImgs(string $img)
    {
        $img = $this->infoService->getOne($img);
        if ($img) {
            $result = $this->infoService->deleteinfoImgs($img);
            return redirect()->route('admin.info.imgs.index')->with('msg', 'Xóa danh mục thành công');
        }
        return redirect()->route('admin.info.imgs.index')->with('err', 'Có lỗi xảy ra, không thể xóa thông tin danh mục này');
    }
}