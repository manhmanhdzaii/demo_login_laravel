
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/cart.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="#">Home</a>/<a href="#">Cart</a>
        </div>
    </div>
    <div class="main_container">
        <div class="container_box1">
            <img src="{{asset('template')}}/images/imgcart.png" alt="">
        </div>
        <form class="container_box2" action="{{route('updateCart')}}" method="post">
            @csrf
            @php
             $carts = Session::get('carts');
            @endphp
            @if (!empty($carts))
            @php
            $products = getProductCart($carts);
            $total = 0;
            @endphp
            <div class="table_cart">
                <table>
                    <tr>
                        <td width="6%">

                        </td>
                        <td width="54%">
                            Product
                        </td>
                        <td width="20%">
                            Quantity
                        </td>
                        <td width="20%">
                            Subtotal
                        </td>
                    </tr>
                    @foreach($products as $product)
                    @php
                    $id = $product->id;
                    $amount = $carts[$id];
                    $price = $product->price * $amount;
                    $total += $price;
                    @endphp
                    <tr>
                        <td>
                            <div class="img_delete">
                                <img src="{{asset('template')}}/images/delete_cart.png" alt="">
                            </div>
                        </td>
                        <td class="product">
                            <a href="{{route('detailProducts', $id)}}">
                            <img src="/{{$product->img}}" alt="">
                            </a>
                            <div class="detail_product">
                                <a href="{{route('detailProducts', $id)}}">
                                <p class="name_product">
                                    {{$product->name}}
                                </p>
                                </a>
                                <p class="price_product">
                                    {{ format_price($product->price) }}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="amount_product">
                                <div class="count_minus">
                                    -
                                </div>
                                <input type="number" value="{{$amount}}" name="name_product[{{$id}}]">


                                <div class="count_add">
                                    +
                                </div>
                            </div>
                        </td>
                        <td class="price_total_product">
                            {{ format_price($price) }}
                        </td>
                    </tr>
                   @endforeach
                    <tr class="tr_total">
                        <td></td>
                        <td colspan="2" class="text_total">It is our pleasure to serve you!</td>
                        <td>
                            <div class="total_all">
                                {{ format_price($total) }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="handle">
                <button class="button_update" type="submit">
                    UPDATE CART
                </button>
               <a href="{{route('checkout')}}"><button class="button_checkout" type="button">
                    PROCESS TO CHECK OUT
                </button></a>
            </div>
            @else
            <div class="null_cart">Kh??ng c?? s???n ph???m n??o trong gi??? h??ng !</div>
            @endif
        </form>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/cart.js"></script>
@endsection