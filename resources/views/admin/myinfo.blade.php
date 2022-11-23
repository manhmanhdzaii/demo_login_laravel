@extends('layouts.admin')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thông tin cá nhân</h1>
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
        <label for="">Tên</label>
        <input name="name" type="text" class="form-control" placeholder="Tên...."
            value="{{old('name') ?? $user->name}}">
        @error('name')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Email</label>
        <input name="email" type="text" class="form-control" placeholder="Email...."
            value="{{old('email') ?? $user->email}}">
        @error('email')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Mật khẩu(Không nhập nếu không đổi)</label>
        <input name="password" type="password" class="form-control" placeholder="Password....">
        @error('password')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Chức vụ</label>
        <select name="role" class="form-control" id="role" disabled>
            <option value="">Chọn chức vụ</option>
            <option value="nomal" {{ $user->role == 'nomal' || old('role') == 'nomal' ? 'selected' : ''}}>Người dùng
            </option>
            <option value="admin" {{ $user->role == 'admin' || old('role') == 'admin' ? 'selected' : ''}}>Admin</option>
        </select>
        @error('role')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Nhóm</label>
        <select name="group_id" class="form-control" id="group_id">
            <option value="">Chọn nhóm</option>
            @php 
                $groups = getGroups();
            @endphp
            @foreach($groups as $group)
                <option value="{{$group->id}}" {{ $user->group_id == $group->id || old('group_id') == $group->id ? 'selected' : ''}}>{{$group->name}}
                </option>
            @endforeach

        </select>
        @error('group_id')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="">Kích hoạt</label>
        <select name="email_verified_at" class="form-control" id="email_verified_at">
            <option value="">Chọn kích hoạt</option>
            <option value="0" {{$user->email_verified_at == NULL || old('email_verified_at') == '0' ? 'selected' : ''}}>
                Không kích hoạt</option>
            <option value="1" {{$user->email_verified_at != NULL || old('email_verified_at') == '1' ? 'selected' : ''}}>
                Kích hoạt</option>
        </select>
        @error('email_verified_at')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">Cập nhật</button>
    @csrf
</form>
@endsection