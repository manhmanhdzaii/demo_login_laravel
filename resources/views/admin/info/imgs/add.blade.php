@extends('layouts.admin')

@section('title', 'Thêm hình ảnh')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm hình ảnh</h1>
</div>

@if($errors->any())
<div class="alert alert-danger text-center">
    Vui lòng kiểm tra dữ liệu nhập vào
</div>
@endif

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="">Tiêu đề</label>
        <input name="title" type="text" class="form-control" placeholder="Nhập tiêu đề..." value="{{old('title')}}">
        @error('title')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Hình ảnh</label>
        <div class="custom-file">
            <input type="file" class="form-control" id="img" name="path" 
                onchange="loadFile1(event,this);">
            <label class="custom-file-label" for="img">Choose file</label>
        </div>
        @error('path')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <div class="img_prew">

        </div>
    </div>
    <button class="btn btn-primary" type="submit">Thêm mới</button>
    @csrf
</form>
@endsection