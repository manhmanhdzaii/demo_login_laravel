@extends('layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách người dùng</h1>
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
@can('users.add')
<p><a href="{{route('admin.users.add')}}" class="btn btn-primary">Thêm mới</a></p>
@endcan
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="5%">STT</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Role</th>
            <th>Active</th>
            @can('users.edit')
            <th width="5%">Sửa</th>
            @endcan
            @can('users.delete')
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
            <td>{{ $list->email }}</td>
            <td>{{ $list->role }}</td>
            <td>{{ $list->email_verified_at != NULL ? 'Đã kích hoạt' : 'Chưa kích hoạt'}}</td>
            @can('users.edit')
            <td>
                <a href="{{route('admin.users.edit', $list->id)}}" class="btn btn-warning">Sửa</a>
            </td>
            @endcan
            @can('users.delete')
            <td>
                @if(Auth::user()->id != $list->id )
                <a href="{{route('admin.users.delete', $list->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn xóa ?')">Xóa</a>
                 @endif
            </td>
            @endcan
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@endsection