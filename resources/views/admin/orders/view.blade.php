@extends('layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách đơn hàng</h1>
</div>
@if(session('msg'))
<div class="alert alert-success">
    {{session('msg')}}
</div>
@endif
@if(session('err'))
<div class="alert alert-danger">
    {{session('err')}}
</div>
@endif
<p><a href="{{route('admin.orders.index')}}" class="btn btn-primary">Quay lại</a></p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">STT</th>
            <th>Tên sản phẩm</th>
            <th>Giá sản phẩm</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
      <?php $total = 0;?>
        @if($lists->count() > 0)
        @foreach($lists as $key => $list)
        @php 
        $price = $list->price * $list->amount;
        $total = $total + $price;
        @endphp
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $list->product->name }}</td>
            <td>{{ format_price($list->price) }}</td>
            <td>{{ $list->amount }}</td>
            <td>{{  format_price($price) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4">Tổng thanh toán</td>
            <td>{{format_price($total)}}</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center">
{{ $lists->links() }}
</div>
@endsection