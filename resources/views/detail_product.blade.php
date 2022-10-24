
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/detail_product.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="/">Home</a> / <a href="{{route('listProducts')}}">Shop</a> / <a href="#">{{ $product->name }}</a>
        </div>
    </div>
    <div class="main_container">
        <div class="main_img">
            <div class="main_img_demo">
                <div class="item_img_demo item_img_demo_tick">
                    <img src="/{{$product->img}}">
                </div>
                <?php $listImg = getListImg($product->id); ?>
                @foreach ($listImg as $img)
                <div class="item_img_demo">
                    <img src="/{{$img->path}}">
                </div>
                @endforeach
            </div>
            <div class="main_img_show">
                <img src="/{{$product->img}}">
            </div>
        </div>
        <div class="main_content">
            <div class="content_title">
                <p>{{ $product->name }}</p>
                <p class="title_type">HOT</p>
            </div>
            <div class="content_price">
                {{ format_price($product->price) }}
            </div>
            <div class="content_text">
                Get this: you can look good while being environmentally conscious. The women's premium organic
                t-shirt is made up of 100% organic cotton, making it crew and comfy. Plus, the shirt promises the
                best-possible print results, making it an excellent choice for those looking to customize.
            </div>
            <form class="content_add_cart" method="post" action="{{route('addCart')}}">
                <div class="add_cart_subtraction">-</div>
                <input type="text" class="add_cart_value" value="1" name="add_cart_value">
                <div class="add_cart_summation">+</div>
                <input type="hidden" value="{{$product->id}}" name="product_id">
                <input class="add_cart_to" value ="ADD TO CART" type="submit">
                @csrf
            </form>
            <div class="content_des">
                <div class="content_des_title">
                    <p>Description</p><img src="{{asset('template')}}/images/detai_it_title.png" alt="">
                </div>
                <div class="content_des_content">
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>Woman 3-piece dress suits: 100% organic cotton</p>
                    </div>
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>Dry clean only</p>
                    </div>
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>This product contains (suit, vest and pants)</p>
                    </div>
                </div>
            </div>
            <div class="content_des">
                <div class="content_des_title">
                    <p>Additional Information</p><img src="{{asset('template')}}/images/detai_it_title.png" alt="">
                </div>
                <div class="content_des_content">
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>Category: {{getNameCategory($product->category_id)}}, {{getColorByString($product->color_id)}}</p>
                    </div>
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>Size: {{getSizeByString($product->size_id)}}</p>
                    </div>
                </div>
            </div>
            <div class="content_des">
                <div class="content_des_title">
                    <p>Shipping and Returns</p><img src="{{asset('template')}}/images/detai_it_title.png" alt="">
                </div>
                <div class="content_des_content">
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>Delivery in 5-7 days</p>
                    </div>
                    <div class="ct_des_item">
                        <img src="{{asset('template')}}/images/item_img.png" alt="">
                        <p>Free shipping (New York area only)</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/detail_product.js"></script>
@endsection