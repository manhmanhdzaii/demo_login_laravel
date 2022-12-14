@extends('layouts.admin')

@section('title', 'Thêm module')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm module</h1>
</div>

@if($errors->any())
<div class="alert alert-danger text-center">
    Vui lòng kiểm tra dữ liệu nhập vào
</div>
@endif

<form action="" method="post">
    <div class="mb-3">
        <label for="">Tên module</label>
        <input name="name" type="text" class="form-control" placeholder="Nhập tên module...." value="{{old('name')}}">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Tiêu đề module</label>
        <input name="title" type="text" class="form-control" placeholder="Nhập tiêu đề module...." value="{{old('title')}}">
        @error('title')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Chức năng module</label>
        <select name="role[]" id="role_module" class="form-control" multiple>
            @foreach($roleList as $name => $role)
            <option value="{{$name}}">{{$role}}</option>
            @endforeach
        </select>
        @error('role')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">Thêm mới</button>
    @csrf
</form>
@endsection