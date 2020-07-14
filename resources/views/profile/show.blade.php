<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/23/2018
 * Time: 8:19 PM
 */ ?>

@extends('layouts.other')


<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css"/>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>

<style>

    .fb-profile img.fb-image-lg {
        z-index: 0;
        width: 100%;
        height:350px;
        margin-bottom: 10px;
    }

    .fb-image-profile {
        margin: -180px 10px 0px 50px;
        z-index: 9;
        width: 20%;
    }


    .profile-nav {
        height: 46px;
        background-color: white;
        border-bottom: 2px solid #E1E1E1;
        margin-bottom: 8px;
    }

    .profile-nav ul > li {
        color: black;
        font-size: 14px;
        float: right;
        line-height: 44px;
        font-weight: 600;
        padding: 0 22px;
        cursor: pointer;
    }

    .profile-nav ul > li > a {
        color: black;
    }

    .profile-nav li.active > a {
        color: black;
        border-bottom: 2px solid #3597B0;
    }


    article {
        background-color: #FFFFFF;
        padding: 10px;
        margin-bottom: 10px;
        margin-top: 10px;
        width: 100%;
        border-radius: 10px;
        text-align: right;
    }

    figure img {
        width: 50px;
        height: 50px;
    }
    .contact{
        background-color:white;
    }

    .glyphicon-folder-open,
    .glyphicon-user,
    .glyphicon-calendar,
    .glyphicon-eye-open,
    .glyphicon-comment {
        padding: 5px;
    }


    @media (max-width: 768px) {

        .fb-profile-text > h1 {
            font-weight: 700;
            font-size: 16px;
        }

        .fb-image-profile {
            margin: -45px 10px 0px 25px;
            z-index: 9;
            width: 20%;
        }
    }
    
    .img {
  width: 250px;
  height: 250px;
  border:2px solid #000;
  background: url(asset(public/uploads/images/guest.jpg) ) no-repeat;
  -moz-box-shadow: 0px 6px 5px #ccc;
  -webkit-box-shadow: 0px 6px 5px #ccc;
  box-shadow: 0px 6px 5px #ccc;
  -moz-border-radius:190px;
  -webkit-border-radius:190px;
  border-radius:190px;
}


    .showImage{
        position:absolute;
        right:0;
        left:0;
        bottom:0;
        top:0;
        height:100%;
        width:100%;
        background-color:rgba(0,0,0,0.6);
        display:none;
        
    }
    
    @media  (max-width:700px){
        .avatar2{
            padding-top:200px;
        }
    }

</style>

@section('content')

    <!-- contact section  -->
    <section class="contact" style="background-color:white;">
        
        <div class="container" style="border:solid 1px gray">
            <div class="row">
                
                <div class="fb-profile" style="margin-top: 0px;">
    <div class="profile_cover" style="background-image: url({{ asset('public/uploads/covers/'.$user->cover) }});
        background-size: cover;
        background-repeat: no-repeat;
       background-position: center center;
        height:300px;">
        
                    
                    </div>
                    
                    
                    {{--  <a data-fancybox="gallery" href="{{ asset('public/uploads/avatar/'.$user->avatar) }}">
                        <img align="right" src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                             class="fb-image-profile avatar img-circle img-thumbnail" alt="avatar" id="avatar"
                             style="height: 224px;width: 228px;">
                    </a> --}}
                    

                            <img align="right" src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                             class="fb-image-profile avatar img-circle img-thumbnail bg-green" alt="avatar" id="avatar"
                             style="height: 210px;width: 214px;border: solid 4px #fff;;border-radius: 50%;">
                 
  <!--<img align="right" src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"-->
  <!--                           class="fb-image-profile avatar img-circle img-thumbnail" alt="avatar" id="avatar"-->
  <!--                           style="height: 250px;width: 254px;">-->
 
                    {{-- <img align="right" class="fb-image-profile img-circle img-thumbnail"
                          src="https://lorempixel.com/180/180/people/9/"
                          alt="Profile image example"/>--}}
                    <div class="fb-profile-text">
                         <!--Nav -->
                        <nav class="profile-nav" >
                            <ul class="text-black" style="list-style-type:none;color:black;" >
                                <li class="{{ setActive($user->username.'/approval') }}"><a
                                            href="{{ url($user->username.'/approval') }}">تم قبولها</a>
                                </li>
                                <li class="{{ setActive($user->username.'/pending') }}"><a
                                            href="{{ url($user->username.'/pending') }}">قيد المراجعة</a>
                                </li>
                                <!--<li class="{{ setActive($user->username.'/decline') }}"><a-->
                                <!--            href="{{ url($user->username.'/decline') }}">مرفوضة</a>-->
                                <!--</li>-->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row" style="background-color: #CCCACA">
                <div class="col-md-12">
                    <div class="row" style="margin-top: 3px">
                        <div class="col-md-3" style="background-color: #E2E2E2; color: #000000;">
                            <div class="text-center">

                                <br>
                                @if(Auth::check())
                                    @if(Auth::user()->id != $user->id)
                                        @if(Auth::user()->followings()->where('leader_id', $user->id)->get()->count() > 0)
                                            <button class="btn btn-danger btn-block btn-lg"
                                                    onclick="event.preventDefault();
                                                     document.getElementById('follow-form').submit();">
                                                إلغاء المتابعة
                                            </button>
                                            <form id="follow-form"
                                                  action="{{ url('/'.$user->username.'/unfollow') }}"
                                                  method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        @else
                                            <button class="btn btn-success btn-block btn-lg"
                                                    onclick="event.preventDefault();
                                                     document.getElementById('follow-form').submit();">
                                                متابعة
                                            </button>
                                            <form id="follow-form"
                                                  action="{{ url('/'.$user->username.'/follow') }}"
                                                  method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        @endif
                                    @else
                                        <button class="btn btn-success btn-block btn-lg"
                                                onclick="window.location.href='{{ url('/ipanel/dashboard') }}'">
                                            إضافة كلمة/مصطلح جديد
                                        </button>
                                    @endif
                                @endif

                                <h3>{{ $user->name }}</h3>
                                <span>
                            <a href="{{ url('/'.$user->username) }}">
                                <span dir="ltr" style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </span>
                                <br>
                                <p>{{ $user->bio }}</p>

                                <hr>
                                <br><br>

                                <p>
                                    <i class="fa fa-map-marker"></i>
                                    {{ (isset($user->location)) ? $user->location : 'لم يتم تحديدها' }}
                                </p>

                                @if(isset($user->website))
                                    <p>
                                        <i class="fa fa-external-link"></i>
                                        <a href="{{ $user->website }}">{{ $user->website }}</a>
                                    </p>
                                @endif

                                <br><br>

                                <div class="row" style="padding-bottom: 10px;">
                                    <div class="col-md-6">
                                        <a href="{{ url('/'.$user->username.'/followers') }}" style="color: #000000;">
                                            {{ $user->followings->count() }}
                                            متابَعون
                                        </a>

                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('/'.$user->username.'/followings') }}" style="color: #000000;">
                                            {{ $user->followers->count() }}
                                            متابعون
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-9">

                          {{--  <div class="row">
                                @if(session('message'))
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-block {{ session('type') }} fade in">
                                                <button type="button" class="close" data-dismiss="alert"></button>
                                                <span>{{ session('message') }}</span>

                                                <br>
                                                @if(count( $errors ) > 0)
                                                    @foreach ($errors->all() as $error)
                                                        <div>- {{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>--}}
                        
                        


                     @yield('contenttt')
                        <!---->
                            <!---->
                            <!---->
                            <!---->
                            <!---->
                            <!---->
                            <!---->


                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /container -->
        
        <div class="container">
            
            <!--             <div class="row">-->
            <!--    <div class="fb-profile" style="margin-top: 5px;">-->
                   
            <!--        <div class="fb-profile-text">-->
            <!--            <nav class="profile-nav" >-->
            <!--                <ul class="text-black" style="list-style-type:none;" >-->
            <!--                    <li class="{{ setActive($user->username.'/approval') }}"><a-->
            <!--                                href="{{ url($user->username.'/approval') }}">تم قبولها</a>-->
            <!--                    </li>-->
            <!--                    <li class="{{ setActive($user->username.'/pending') }}"><a-->
            <!--                                href="{{ url($user->username.'/pending') }}">قيد المراجعة</a>-->
            <!--                    </li>-->
            <!--                    <li class="{{ setActive($user->username.'/decline') }}"><a-->
            <!--                                href="{{ url($user->username.'/decline') }}">مرفوضة</a>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </nav>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            
            
        </div>
        
        
        
        <div class="showImage" style="text-align:center;">
            
    <img src="{{ asset('public/uploads/avatar/'.$user->avatar)}}" class=" avatar2 " alt="avatar2" style="
    margin:auto;padding-top:300px;width:300px;height:auto;
    " id="">
            
        </div>
        
        
        
        
        
    </section>

@endsection
@section('extraJS')

    <script>
        $(document).ready(function () {
            console.log("ready!");
            $(".avatar").click(function(){
                // console.log('show');
                $('.showImage').show(400);
                $('body').css('overflow','hidden');
                
                    $(".showImage").click(function(){
                    // console.log('hide');
                    $('.showImage').hide();
                });
            });
            
            
        });
    </script>
    {{-- <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"
             type="text/javascript"></script>
     <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"
             type="text/javascript"></script>

     <script src="{{ themeUrl('backend/assets/pages/scripts/components-editors.min.js') }}"
             type="text/javascript"></script>--}}
@endsection
