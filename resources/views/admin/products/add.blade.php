@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')
@section('header')
<script src="/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm sản phẩm</h1>
</div>

@if($errors->any())
<div class="alert alert-danger text-center">
    Vui lòng kiểm tra dữ liệu nhập vào
</div>
@endif

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="">Tên sản phẩm</label>
        <input name="name" type="text" class="form-control" placeholder="Nhập tên sản phẩm...." value="{{old('name')}}">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Giá sản phẩm ($)</label>
        <input name="price" type="number" class="form-control" placeholder="Nhập giá sản phẩm...." value="{{old('price')}}">
        @error('price')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Màu sản phẩm</label>
        <select name="color_id[]" id="color_id" class="form-control" multiple>
            @foreach($colors as $color)
            <option value="{{$color->id}}">{{$color->name}}</option>
            @endforeach
        </select>
        @error('color_id')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Size sản phẩm</label>
        <select name="size_id[]" id="size_id" class="form-control" multiple>
            @foreach($sizes as $size)
            <option value="{{$size->id}}">{{$size->name}}</option>
            @endforeach
        </select>
        @error('size_id')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Danh mục</label>
       <select name="category_id" id="category_id" class="form-control">
        <option value="">Chọn danh mục</option>
        @if($categories->count()>0)
        @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
        @endif
       </select>
       @error('category_id')
       <span style="color:red">{{$message}}</span>
         @enderror
    </div>
    <div class="mb-3">
        <label for="">Hình ảnh sản phẩm</label>
        <div class="custom-file">
            <input type="file" class="form-control" id="img" name="img" 
                onchange="loadFile1(event,this);">
            <label class="custom-file-label" for="img">Choose file</label>
        </div>
       @error('img')
       <span style="color:red">{{$message}}</span>
         @enderror
    </div>
    <div class="mb-3">
        <div class="img_prew">

        </div>
    </div>
    <div class="mb-3">
        <label for="">Hình ảnh kèm theo(tối đa 4)</label>
        <div class="custom-file">
            <input type="file" class="form-control" id="img_sub" name="img_sub[]" 
                onchange="loadFile(event,this);" multiple>
            <label class="custom-file-label" for="img_sub">Choose file</label>
        </div>
       @error('img_sub')
       <span style="color:red">{{$message}}</span>
         @enderror
    </div>
    <div class="mb-3">
        <div class="img_prew_sub">

        </div>
    </div>
    <div class="mb-3">
        <label for="">Mô tả chi tiết</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        @error('description')
        <span style="color:red">{{$message}}</span>
          @enderror
    </div>

    <button class="btn btn-primary" type="submit">Thêm mới</button>
    @csrf
</form>
@endsection

@section('footer')
<script>
    CKEDITOR.replace('description');
    </script>
@endsection