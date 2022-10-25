
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/order.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="/">Home</a>/<a href="#">Danh sách đơn hàng</a>
        </div>
    </div>
    <div class="main_container">
        <div class="container_box1">
            <img src="{{asset('template')}}/images/imgcart.png" alt="">
        </div>
        <div class="container_box2">
            @if($lists->count() > 0)
            @foreach ($lists as $key => $list)
            @php 
                $type= getTypeOrder();
                $order_details = getProductOrder($list->id);
                $name_product = [];
                foreach ($order_details as $order_detail){
                    $name_product[] = $order_detail->product->name;
                }
                $name_order = implode(', ',$name_product);


            @endphp
            <div class="all_order">
                <div class="info_order">
                    <div class="stt_order">{{ $key + 1}}</div>
                    <div class="name_order">{{ $name_order }}</div>
                    <div class="day_start">{{ $list->created_at }}</div>
                    <div class="type_order">{{ $type[$list->type] }}</div>
                    <div class="btn_view">
                        <button class="btn_type btn_show">Xem chi tiết</button>
                    </div>
                </div>
                <div class="table_cart hidden">
                    <table>
                        <tr>
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
                        <?php $total = 0;?>
                        @foreach($order_details as $order_detail)
                        @php 
                        $price = $order_detail->price * $order_detail->amount;
                        $total += $price;
                        @endphp
                        <tr>
                            <td class="product">
                                <img src="/{{$order_detail->product->img}}" alt="">
                                <div class="detail_product">
                                    <p class="name_product">
                                        {{$order_detail->product->name}}
                                    </p>
                                    <p class="price_product">
                                        {{ format_price($order_detail->price) }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="amount_product">
                                    {{$order_detail->amount}}
                                </div>
                            </td>
                            <td class="price_total_product">
                                {{ format_price($price) }}
                            </td>
                        </tr>
                        @endforeach
                        <td colspan="2" class="text_total">Tổng tiền</td>
                        <td>
                            <div class="total_all">
                                {{ format_price($total) }}
                            </div>
                        </td>
                    </table>
                </div>
            </div>
            @endforeach
            @else
            <div class="zero_order">
                Bạn chưa có đơn hàng nào !
            </div>
            @endif

        </div>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/order.js"></script>
@endsection