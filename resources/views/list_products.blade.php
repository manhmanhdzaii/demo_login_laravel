
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/list_products.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="/">Home</a>/<a href="#">Shop</a>
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
                        <div class="c2_find_b1_item_hidden c2_find_b1_item hidden c2_find_b1_item_check" value="0">
                        </div>
                        <?php $listCategories = getCategories(); ?>
                        @foreach ($listCategories as $category)
                        <div class="c2_find_b1_item search" value="{{ $category->id }}">
                            {{ $category->name }}
                        </div>
                        @endforeach
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
                            <div class="filter_price search" value="0">
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
                            <button class="b3_item_color_hidden b3_item_color b3_item_color_check hidden" value="0">
                            </button>
                            <button class="search b3_item_color item_color_white" value="1">

                            </button>
                            <button class="search b3_item_color item_color_black" value="2">

                            </button>
                            <button class="search b3_item_color item_color_red" value="3">

                            </button>
                            <button class="search b3_item_color item_color_yellow" value="4">

                            </button>
                            <button class="search b3_item_color item_color_blue" value="5">

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
                             <button class="b3_item_size b3_item_size_hidden hidden b3_item_size_check" value="0">
                            </button>
                            <button class="search b3_item_size" value="1">
                                S
                            </button>
                            <button class="search b3_item_size" value="2">
                                M
                            </button>
                            <button class="search b3_item_size" value="3">
                                l
                            </button>
                            <button class="search b3_item_size" value="4">
                                xl
                            </button>
                            <button class="search b3_item_size" value="5">
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
                            <div class="list_sort_post list_sort_post_tick search" value="0">Defaut Sorting</div>
                            <div class="list_sort_post search" value="1">Sort by price: low to high</div>
                            <div class="list_sort_post search" value="2">Sort by price: high to low</div>
                        </div>
                    </div>
                </div>
                <div class="b2_list_products">
                    @foreach($lists as $product)
                    <div class="m_box2_item">
                        <div class="m_b2_it_img">
                            <a href="{{route('detailProducts', $product->id)}}"><img src="/{{ $product->img }}"></a>
                            <div class="m_b2_it_type">HOT</div>
                            <div class="m_b2_it_car">
                                <img src="{{asset('template')}}/images/cart_item.png">
                            </div>
                        </div>
                        <a href="{{route('detailProducts', $product->id)}}"><div class="m_b2_it_title">{{ $product->name }}</div></a>
                        <div class="m_b2_it_price">{{ format_price($product->price)}}</div>
                    </div>
                    @endforeach
                </div>
                <div class="paginate_product">
                    {{ $lists->links() }}
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/list_products.js"></script>
@endsection