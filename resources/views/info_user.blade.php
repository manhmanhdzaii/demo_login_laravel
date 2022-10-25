
@extends('layouts.template')

@section('css')
<link rel="stylesheet" href="{{asset('template')}}/css/info_user.css" type="text/css" />
@endsection

@section('content')
<div class="main">
    <div class="main_title">
        <div class="main_link_title">
            <a href="/">Home</a>/<a href="#">Thông tin cá nhân</a>
        </div>
    </div>
    <div class="main_container">
        <div class="container_box1">
            <img src="{{asset('template')}}/images/imgcheckout.png" alt="">
        </div>
        <div class="container_box2">
            <div class="b2_left">
                <a href="#">
                    <div class="b2_left_content">
                        Thông tin cá nhân
                    </div>
                </a>
                <a href="{{route('user.change_pass')}}">
                    <div class="b2_left_content">
                        Đổi mật khẩu
                    </div>
                </a>
            </div>
            <div class="b2_right">
                <div class="right_content">
                    <div class="right_box1">
                        <img src="{{asset('template')}}/images/amico3.png">
                    </div>
                    <form class="right_box2" method="post" action="">
                        @csrf
                        <div class="box2_input">
                            <div class="b2_ip_title">
                               Họ và tên
                            </div>
                            <div class="bag_input">
                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                                <p class="err"></p>
                            </div>
                        </div>
                        <div class="box2_input">
                            <div class="b2_ip_title">
                                Email
                            </div>
                            <div class="bag_input">
                                <input type="text" name="email" id="email" value="{{ Auth::user()->email }}">
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
<script type="text/javascript" src="{{asset('template')}}/js/info_user.js"></script>
@endsection