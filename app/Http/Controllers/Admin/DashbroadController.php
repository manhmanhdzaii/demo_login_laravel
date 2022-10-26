<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashbroadController extends Controller
{
    /**
     * Desc: Giao diện admin sau khi đăng nhập
     *
     */
    public function index()
    {
        return view('admin.dashbroad');
    }
}