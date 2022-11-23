@extends('layouts.admin')

@section('title', 'Danh sách danh mục sản phẩm')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách danh mục sản phẩm</h1>
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
@can('products.add')
<p><a href="{{route('admin.products.add')}}" class="btn btn-primary">Thêm mới</a></p>
@endcan
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">STT</th>
            <th>Tên sp</th>
            <th>Giá sp</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            @can('products.edit')
            <th width="5%">Sửa</th>
            @endcan
            @can('products.delete')
            <th width="5%">Xóa</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if($lists->count() > 0)
        @foreach($lists as $key => $list)
        <tr>
            <td>{{ $key +1 }}</td>
            <td>{{ $list->name }}</td>
            <td>{{ format_price($list->price) }}</td>
            <td class="text-center"><img src='/{{ $list->img }}' width='100px'></td>
            <td>{{ $list->category->name }}</td>
            @can('products.edit')
            <td>
                <a href="{{route('admin.products.edit', $list->id)}}" class="btn btn-warning">Sửa</a>
            </td>
            @endcan
            @can('products.delete')
            <td>
                <a href="{{route('admin.products.delete', $list->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn xóa ?')">Xóa</a>
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