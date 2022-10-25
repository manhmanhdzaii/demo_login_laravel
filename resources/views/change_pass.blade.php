
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/change_pass.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="/">Home</a>/<a href="#">Đổi mật khẩu</a>
        </div>
    </div>
    <div class="main_container">
        <div class="container_box1">
            <img src="{{asset('template')}}/images/imgcheckout.png" alt="">
        </div>
        <div class="container_box2">
            <div class="b2_left">
                <a href="{{route('user.index')}}">
                    <div class="b2_left_content">
                        Thông tin cá nhân
                    </div>
                </a>
                <a href="#">
                    <div class="b2_left_content">
                        Đổi mật khẩu
                    </div>
                </a>
            </div>
            <div class="b2_right">
                <div class="right_content">
                    <div class="right_box1">
                        <img src="{{asset('template')}}/images/img_repass.png">
                    </div>
                    <form class="right_box2" method="post" action="">
                        @csrf
                        <div class="box2_input">
                            <div class="b2_ip_title">
                                Mật khẩu hiện tại
                            </div>
                            <div class="bag_input">
                                <input type="password" name="password">
                                <p class="err"> @error('password') {{$message}} @enderror
                                    @if(session('err'))
                                    {{session('err')}}
                                     @endif
                                </p>
                            </div>
                        </div>
                        <div class="box2_input">
                            <div class="b2_ip_title">
                                Mật khẩu mới
                            </div>
                            <div class="bag_input">
                                <input type="password" name="new_password">
                                <p class="err">@error('new_password') {{$message}} @enderror
                                </p>
                            </div>
                        </div>
                        <div class="box2_input">
                            <div class="b2_ip_title">
                                Xác nhận mật khẩu
                            </div>
                            <div class="bag_input">
                                <input type="password" name="re_password" id="re_password">
                                <p class="err"></p>
                            </div>
                        </div>
                        <button type="submit" class="btn_update">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('template')}}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{asset('template')}}/js/change_pass.js"></script>
@endsection