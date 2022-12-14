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
<form class="form_list_search" action="" method="get">
    <div class="input-group">
        <input type="text" class="form-control small" placeholder="Tìm kiếm..." aria-label="Search"
            aria-describedby="basic-addon2" name="name" value="{{ isset($_GET['name']) ? $_GET['name'] : ''}}">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">STT</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ngày đặt hàng</th>
            <th>Trạng thái</th>
            @can('orders.viewDetail')
            <th width="5%">Xem</th>
            @endcan
            @can('orders.delete')
            <th width="5%">Xóa</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if($lists->count() > 0)
        <?php $types = getTypeOrder();?>    
        @foreach($lists as $key => $list)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $list->customer->name }}</td>
            <td>{{ $list->customer->phone }}</td>
            <td>{{ $list->customer->email }}</td>
            <td>{{ $list->customer->created_at }}</td>
            <td>
                <select name="" id="" style="outline:none" class="select_type" @cannot('orders.updateStatus') disabled @endcan>
                    @foreach($types as $key => $type)
                            <option value="{{$key}}" {{$list->type == $key ? ' selected' : ''}}>{{$type}}</option>
                    @endforeach
                </select>
                <input type="hidden" value="{{ $list->id }}" class="id_order">
            </td>
            @can('orders.viewDetail')
            <td>
                <a href="{{route('admin.orders.view', $list->id)}}" class="btn btn-warning">Xem</a>
            </td>
            @endcan
            @can('orders.delete')
            <td>
                <a href="{{route('admin.orders.delete', $list->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn xóa ?')">Xóa</a>
            </td>
            @endcan
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<div class="d-flex justify-content-center">
{{ $lists->links() }}
</div>
@endsection