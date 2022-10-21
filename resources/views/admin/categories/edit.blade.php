@extends('layouts.admin')

@section('title', 'Sửa danh mục sản phẩm')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa danh mục sản phẩm</h1>
</div>

@if($errors->any())
<div class="alert alert-danger text-center">
    Vui lòng kiểm tra dữ liệu nhập vào
</div>
@endif
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
<form action="" method="post">
    <div class="mb-3">
        <label for="">Tên danh mục</label>
        <input name="name" type="text" class="form-control" placeholder="Nhập tên danh mục...." value="{{old('name') ?? $category->name}}">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">Cập nhật</button>
    @csrf
</form>
@endsection