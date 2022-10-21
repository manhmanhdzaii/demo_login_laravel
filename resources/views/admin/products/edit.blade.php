@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('header')
<script src="/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa sản phẩm</h1>
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
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="">Tên sản phẩm</label>
        <input name="name" type="text" class="form-control" placeholder="Nhập tên sản phẩm...." value="{{$product->name}}">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Giá sản phẩm</label>
        <input name="price" type="number" class="form-control" placeholder="Nhập giá sản phẩm...." value="{{$product->price}}">
        @error('price')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Màu sản phẩm</label>
        <select name="color_id[]" id="color_id" class="form-control" multiple>
            <?php $arr_colors = explode(',',$product->color_id);?>
            @foreach($colors as $color)
            <option value="{{$color->id}}" <?php echo in_array($color->id,$arr_colors) ? 'selected' : ''?>>{{$color->name}}</option>
            @endforeach
        </select>
        @error('color_id')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Size sản phẩm </label>
        <select name="size_id[]" id="size_id" class="form-control" multiple>
            <?php $arr_sizes = explode(',',$product->size_id);?>
            @foreach($sizes as $size)
            <option value="{{$size->id}}" <?php echo in_array($size->id,$arr_sizes) ? 'selected' : ''?>>{{$size->name}}</option>
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
        <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
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
            <a class="img_show"><img src="/{{$product->img}}" ><i class="fas fa-trash delete_imgshow" onclick="Remove_ImgShow(this)"></i></a>
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
            @if($list_img->count()>0)
                @foreach ($list_img as $item)
                <a class="img_show"><img src="/{{$item->path}}" ><i class="fas fa-trash delete_imgshow" onclick="Remove_ImgShow(this)"></i></a>
                @endforeach
            @endif
        </div>
    </div>
    <div class="mb-3">
        <label for="">Mô tả chi tiết</label>
        <textarea name="description" id="description" class="form-control">{{$product->description}}</textarea>
        @error('description')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>

    <button class="btn btn-primary" type="submit">Cập nhật</button>
    @csrf
</form>
@endsection

@section('footer')
<script>
    CKEDITOR.replace('description');
    </script>
@endsection