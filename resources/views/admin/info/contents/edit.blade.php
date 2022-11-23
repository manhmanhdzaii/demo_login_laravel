@extends('layouts.admin')

@section('title', 'Sửa nội dung')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa nội dung</h1>
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
        <label for="">Tiêu đề</label>
        <input name="title" type="text" class="form-control" placeholder="Nhập tiêu đề...." value="{{old('title') ?? $info->title}}">
        @error('title')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Nội dung</label>
        <input name="content" type="text" class="form-control" placeholder="Nhập nội dung...." value="{{old('content') ?? $info->content}}">
        @error('content')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">Cập nhật</button>
    @csrf
</form>
@endsection