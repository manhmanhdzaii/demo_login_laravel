@extends('layouts.admin')

@section('title', 'Thêm nhóm người dùng')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm nhóm người dùng</h1>
</div>

@if($errors->any())
<div class="alert alert-danger text-center">
    Vui lòng kiểm tra dữ liệu nhập vào
</div>
@endif

<form action="" method="post">
    <div class="mb-3">
        <label for="">Tên nhóm</label>
        <input name="name" type="text" class="form-control" placeholder="Nhập tên nhóm...." value="{{old('name')}}">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">Thêm mới</button>
    @csrf
</form>
@endsection