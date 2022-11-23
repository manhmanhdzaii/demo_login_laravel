@extends('layouts.admin')

@section('title', 'Phân quyền nhóm ' . $group->name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Phân quyền nhóm {{ $group->name }}</h1>
</div>
@if(session('msg'))
<div class="alert alert-success">
    {{session('msg')}}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger text-center">
    Vui lòng kiểm tra dữ liệu nhập vào
</div>
@endif

<form action="" method="post">
    @csrf
    <table class="table table-bordered">
        <thead>
            <tr>
                <th with="10%">Module</th>
                <th>Quyền</th>
            </tr>
        </thead>
        <tbody>
            @if($modules->count() > 0)
            @foreach($modules as $module)
            @php 
            $roleArr = explode(',',$module->role);
            @endphp
           <tr>
            <td>
                {{$module->title}}
            </td>
            <td>
                <div class="row">
                    @foreach($roleArr as $role)
                    <div class="col-3">
                        <label for="role_{{$module->name}}_{{$role}}">
                         <input type="checkbox" name="role[{{$module->name}}][]" id="role_{{$module->name}}_{{$role}}" value="{{$role}}"
                          {{isRole($roleModule, $module->name, $role) ? 'checked' : false}}>
                         {{$roleList[$role]}}
                        </label>
                    </div>
                    @endforeach
                </div>
            </td>
           </tr>
           @endforeach
           @endif
        </tbody>
    </table>
    <button class="btn btn-primary" type="submit">Phân quyền</button>
</form>
@endsection