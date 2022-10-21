
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
        <div class="container_box2">
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
                    <tr>
                        <td>
                            <div class="img_delete">
                                <img src="{{asset('template')}}/images/delete_cart.png" alt="">
                            </div>
                        </td>
                        <td class="product">
                            <img src="{{asset('template')}}/images/img_demo1.png" alt="">
                            <div class="detail_product">
                                <p class="name_product">
                                    T-SHIRT WITH CREW NECK
                                </p>
                                <p class="price_product">
                                    $ 312.00
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="amount_product">
                                <div class="count_minus">
                                    -
                                </div>
                                <input type="number">


                                <div class="count_add">
                                    +
                                </div>
                            </div>
                        </td>
                        <td class="price_total_product">
                            312.00 $
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="img_delete">
                                <img src="{{asset('template')}}/images/delete_cart.png" alt="">
                            </div>
                        </td>
                        <td class="product">
                            <img src="{{asset('template')}}/images/img_demo1.png" alt="">
                            <div class="detail_product">
                                <p class="name_product">
                                    T-SHIRT WITH CREW NECK
                                </p>
                                <p class="price_product">
                                    $ 312.00
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="amount_product">
                                <div class="count_minus">
                                    -
                                </div>
                                <input type="number">


                                <div class="count_add">
                                    +
                                </div>
                            </div>
                        </td>
                        <td class="price_total_product">
                            312.00 $
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="img_delete">
                                <img src="{{asset('template')}}/images/delete_cart.png" alt="">
                            </div>
                        </td>
                        <td class="product">
                            <img src="{{asset('template')}}/images/img_demo1.png" alt="">
                            <div class="detail_product">
                                <p class="name_product">
                                    T-SHIRT WITH CREW NECK
                                </p>
                                <p class="price_product">
                                    $ 312.00
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="amount_product">
                                <div class="count_minus">
                                    -
                                </div>
                                <input type="number">


                                <div class="count_add">
                                    +
                                </div>
                            </div>
                        </td>
                        <td class="price_total_product">
                            312.00 $
                        </td>
                    </tr>
                    <tr class="tr_total">
                        <td></td>
                        <td colspan="2" class="text_total">It is our pleasure to serve you!</td>
                        <td>
                            <div class="total_all">
                                1,349.00 $
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="handle">
                <button class="button_update">
                    UPDATE CART
                </button>
                <button class="button_checkout">
                    PROCESS TO CHECK OUT
                </button>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/cart.js"></script>
@endsection