
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/list_products.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="#">Home</a>/<a href="#">Shop</a>/<a href="#">For Men</a>
        </div>
    </div>
    <div class="main_container">
        <div class="container_box1">
            <img src="{{asset('template')}}/images/list_banner.png" alt="">
        </div>
        <div class="container_box2">
            <div class="c_b2_find">
                <div class="b2_find_b1">
                    <div class="c2_find_title">
                        PRODUCTS CATEGORY
                    </div>
                    <div class="c2_find_content">
                        <div class="c2_find_b1_item c2_find_b1_item_check">
                            Clothing
                        </div>
                        <div class="c2_find_b1_item">
                            Accessories
                        </div>
                        <div class="c2_find_b1_item">
                            Shoes
                        </div>
                        <div class="c2_find_b1_item">
                            Hat
                        </div>
                    </div>
                </div>
                <div class="b2_find_b2">
                    <div class="c2_find_title">
                        FILTER BY PRICE
                    </div>
                    <div class="c2_find_content">
                        <div class="slider">
                            <div class="progress">
                            </div>
                            <div class="range_input">
                                <input type="range" class="range_min" min="0" max="1000" value="100" step="10">
                                <input type="range" class="range_max" min="0" max="1000" value="900" step="10">
                            </div>
                        </div>
                        <div class="find_price">
                            <div class="pricer_input">
                                <p>$</p><input type="number" class="ip_min" value="100">
                            </div>
                            <div class="separator">-</div>
                            <div class="pricer_input">
                                <p>$</p><input type="number" class="ip_max" value="900">
                            </div>
                            <div class="filter_price">
                                Filter
                            </div>
                        </div>
                    </div>
                </div>
                <div class="b2_find_b3">
                    <div class="c2_find_title">
                        COLOUR
                    </div>
                    <div class="c2_find_content">
                        <div class="b3_box_color">
                            <button class="b3_item_color item_color_white">

                            </button>
                            <button class="b3_item_color item_color_black">

                            </button>
                            <button class="b3_item_color item_color_red">

                            </button>
                            <button class="b3_item_color item_color_yellow">

                            </button>
                            <button class="b3_item_color item_color_blue">

                            </button>
                        </div>
                    </div>
                </div>
                <div class="b2_find_b4">
                    <div class="c2_find_title">
                        SIZE
                    </div>
                    <div class="c2_find_content">
                        <div class="b4_box_size">
                            <button class="b3_item_size">
                                S
                            </button>
                            <button class="b3_item_size">
                                M
                            </button>
                            <button class="b3_item_size">
                                l
                            </button>
                            <button class="b3_item_size b3_item_size_check">
                                xl
                            </button>
                            <button class="b3_item_size">
                                xxl
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="c_b2_list">
                <div class="b2_list_sort">
                    <div class="list_sort_check">
                        <p class="list_sort_check_tittle">Defaut Sorting</p>
                        <img src="{{asset('template')}}/images/arrow_sort.png">
                        <div class="list_sort_all hidden">
                            <div class="list_sort_post">Defaut Sorting</div>
                            <div class="list_sort_post">Sort by price: low to high</div>
                            <div class="list_sort_post">Sort by price: high to low</div>
                        </div>
                    </div>
                </div>
                <div class="b2_list_products">
                    @for($i = 0; $i < 9; $i++) 
                    <div class="m_box2_item">
                        <div class="m_b2_it_img">
                            <a href="{{route('detailProducts')}}"><img src="{{asset('template')}}/images/img_sp.png"></a>
                            <div class="m_b2_it_type">HOT</div>
                            <div class="m_b2_it_car">
                                <img src="{{asset('template')}}/images/cart_item.png">
                            </div>
                        </div>
                        <a href="{{route('detailProducts')}}"><div class="m_b2_it_title">FLORAL FRILL T-SHIRT</div></a>
                        <div class="m_b2_it_price">$ 375.00</div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/list_products.js"></script>
@endsection