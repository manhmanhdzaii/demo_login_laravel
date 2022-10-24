
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/checkout.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="/">Home</a>/<a href="{{route('carts')}}">Cart</a>
        </div>
    </div>
    <div class="main_container">
        <div class="container_box1">
            <img src="{{asset('template')}}/images/imgcheckout.png" alt="">
        </div>
        <form class="container_box2" onsubmit="return false;" id="checkout">
            <div class="box2_left">
                <div class="box2_left_box1">
                    <div class="box2_title">
                        <img src="{{asset('template')}}/images/line_title.png" alt="">
                        <p>YOUR INFORMATION</p>
                    </div>
                    <div class="box_input_container">
                        <div class="box_input">
                            <p>Name</p>
                            <input type="text" name="name" placeholder="Nhập tên..">
                            <p class="err"></p>
                        </div>
                        <div class="box_input">
                            <p>Phone Number</p>
                            <input type="text" placeholder="Nhập số điện thoại..." name="phone"> 
                            <p class="err"></p>
                        </div>
                    </div>
                    <div class="box_input_container">
                        <div class="box_input">
                            <p>Email</p>
                            <input type="text" placeholder="Nhập email.." name="email">
                            <p class="err"></p>
                        </div>
                    </div>
                    <div class="box_input_container">
                        <div class="box_input">
                            <p>Address</p>
                            <input type="text" name="city" placeholder="Nhập địa chỉ..">
                            <p class="err"></p>
                        </div>
                    </div>
                    <div class="box_checkbox_container">
                        <div class="box_checkbox">
                            <input type="radio" name="check_time">
                            <p>Office hours only</p>
                        </div>
                        <div class="box_checkbox">
                            <input type="radio" name="check_time">
                            <p>Every day of the week (matches home address)</p>
                        </div>
                    </div>
                    <p class="err"></p>
                    <div class="box_input_container">
                        <div class="box_input">
                            <p>Note</p>
                            <textarea placeholder="Type something here..." name="note"></textarea>
                            <p class="err"></p>
                        </div>
                    </div>
                </div>
                <div class="box2_left_box2">
                    <div class="box2_title">
                        <img src="{{asset('template')}}/images/line_title.png" alt="">
                        <p>PAYMENT INFORMATION</p>
                    </div>
                    <div class="select_pay">
                        <select>
                            <option value="">Payment by cash when received</option>
                            <option value="">Online</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="box2_right">
                <div class="box2_title">
                    <img src="{{asset('template')}}/images/line_title.png" alt="">
                    <p>YOUR ORDER</p>
                </div>

                <div class="box2_right_title">
                    Products
                </div>
                <div class="all_product">
                    @php
                    $carts = Session::get('carts');
                    $products = getProductCart($carts);
                    $total = 0;
                    @endphp
                    @foreach ($products as $product)
                    @php
                    $id = $product->id;
                    $amount = $carts[$id];
                    $price = $product->price * $amount;
                    $total += $price;
                    @endphp
                    <div class="detail_product">
                        <a href="{{route('detailProducts', $id)}}">
                        <img src="/{{ $product->img }}" alt="">
                        </a>
                        <div class="product_content">
                            <a href="{{route('detailProducts', $id)}}">
                                <div class="product_name">
                                    {{ $product->name }} x{{$amount}}
                                </div>
                            </a>

                            <div class="product_price">
                                {{ format_price($product->price) }}
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="box2_right_title">
                    Order summary
                </div>
                <div class="price_all">
                    <div class="price">
                        <p>Subtotal</p>
                        <p class="price_secon">{{format_price($total)}}</p>
                    </div>
                    <div class="price">
                        <p>Shipping</p>
                        <p class="price_ship">0 $</p>
                    </div>
                </div>
                <div class="price_total">
                    <p>TOTAL</p>
                    <p class="price_after">{{format_price($total)}}</p>
                </div>
                <button class="button_buy" type="submit">
                    CONFIRM ORDER
                </button>
            </div>

        </form>
    </div>
    <div class="popup__all hidden">
        <div class="main__popup">
            <img src="{{asset('template')}}/images/img_logo_send.png" alt="">
            <div class="main__popup_title">
                THANK YOU!
            </div>
            <div class="main__popup_content">
                Thanks for your ordering. Your order is being confirmed and will be delivered as soon as possible.
                Don't forget to keep an eye on your phone and email to receive the latest information from us.
                Best regards!
            </div>
            <a href="/">
                <button class="buttonback">
                    BACK TO HOMEPAGE
                </button>
            </a>
        </div>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{asset('template')}}/js/checkout.js"></script>
@endsection