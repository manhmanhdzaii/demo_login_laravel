<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function listProducts()
    {
        return view('list_products');
    }
    public function detailProducts()
    {
        return view('detail_product');
    }
    public function carts()
    {
        return view('carts');
    }
    public function checkout()
    {
        return view('checkout');
    }
    public function logout()
    {
        Auth::logout();
        return true;
    }
}