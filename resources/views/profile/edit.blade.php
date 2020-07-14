<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/23/2018
 * Time: 8:19 PM
 */ ?>

@extends('layouts.other')

@section('extraCss')
    <link rel="stylesheet"
          href="{{ asset('/public/croppie/croppie.css') }}">
    <style>

        .fb-profile img.fb-image-lg {
            z-index: 0;
            width: 100%;
            margin-bottom: 10px;
            max-height: 385px;
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
            color: #999;
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
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>


@endsection
@section('content')

    <!-- contact section  -->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="fb-profile" style="margin-top: 5px;">
                    
                    
                    <a href="javascript:void(0)" onclick="document.getElementById('update_cover').click()">
                     <div class="fb-profile" style="margin-top: 0px;">
    <div class="profile_cover" style="background-image: url({{ asset('public/uploads/covers/'.$user->cover) }});
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        height:300px;">
        
                    
                    </div>
                        <!--<img align="left" class="fb-image-lg"-->
                        <!--     src="{{ asset('/public/uploads/covers/'.Auth::user()->cover) }}"-->
                        <!--     alt="Profile image example"/>-->
                    </a>
                    <form id="update_cover_form" action="{{ url('/user/profile/settings/update_cover') }}"
                          method="post"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input id="update_cover" type="file" name="cover" style="display: none">
                        </div>
                    </form>


                    <a href="javascript:void(0);"
                       id="change-profile-pic">
                        <img align="right" src="{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}"
                             class="fb-image-profile avatar img-circle img-thumbnail" alt="avatar"
                             style="height: 224px;width: 228px;" id="profile_picture"
                             data-src="{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}"
                             data-holder-rendered="true">
                    </a>
                    {{-- <form id="update_photo_form" action="{{url('/user/profile/settings/update_avatar')}}"
                           method="post"
                           enctype="multipart/form-data">
                         {{csrf_field()}}
                         <div class="form-group">
                             <input id="update_photo" type="file" name="avatar" style="display: none">
                         </div>
                     </form>--}}

                    {{-- <img align="right" class="fb-image-profile img-circle img-thumbnail"
                          src="http://lorempixel.com/180/180/people/9/"
                          alt="Profile image example"/>--}}
                    <div class="fb-profile-text">
                        <!-- Nav -->
                        <nav class="profile-nav">
                           <ul class="text-black" style="list-style-type:none;" >
                                <li class="{{ setActive(Auth::user()->username.'/approval') }}"><a
                                            href="{{ url(Auth::user()->username.'/approval') }}">تم قبولها</a>
                                </li>
                                <li class="{{ setActive(Auth::user()->username.'/pending') }}"><a
                                            href="{{ url(Auth::user()->username.'/pending') }}">قيد المراجعة</a>
                                </li>
                                <!--<li class="{{ setActive(Auth::user()->username.'/decline') }}"><a-->
                                <!--            href="{{ url(Auth::user()->username.'/decline') }}">مرفوضة</a>-->
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

                                <form class="form" action="{{ url('user/profile/settings/update_info') }}"
                                      method="post">
                                    @csrf
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="الإسم بالكامل" title="أدخل الإسم بالكامل"
                                           value="{{ Auth::user()->name }}">

                                    <span>
                                        <a href="{{ url('/'.Auth::user()->username) }}">
                                            <span dir="ltr"
                                                  style="color: #ACACAC;">{{ '@'.Auth::user()->username }}</span>
                                        </a>
                                    </span>

                                    <br>
                                    <input type="email" class="form-control" name="email" id="name"
                                           placeholder="البريد الإلكتروني" title="أدخل البريد الإلكتروني"
                                           value="{{ Auth::user()->email }}">

                                    <textarea name="bio" id="" cols="30" rows="5" class="form-control"
                                              placeholder="أدخل الوصف">{{ Auth::user()->bio }}</textarea>

                                    <hr>

                                    <input type="text" class="form-control" name="location" id="name"
                                           placeholder="أدخل العنوان" title="أدخل العنوان"
                                           value="{{ Auth::user()->location }}">


                                    <input type="url" class="form-control" name="website" id="name"
                                           placeholder="أدخل الموقع الإلكتروني" title="أدخل الموقع الإلكتروني"
                                           value="{{ Auth::user()->website }}">

                                    <hr>
                                    <button class="btn btn-lg btn-success" type="submit"><i
                                                class="glyphicon glyphicon-ok-sign"></i> تحديث المعلومات
                                    </button>
                                </form>


                                <br><br>

                                <div class="row" style="padding-bottom: 10px;">
                                    <div class="col-md-6">
                                        <a href="{{ url('/'.Auth::user()->username.'/followers') }}"
                                           style="color: #000000;">
                                            {{ Auth::user()->followings->count() }}
                                            متابَعون
                                        </a>

                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('/'.Auth::user()->username.'/followings') }}"
                                           style="color: #000000;">
                                            {{ Auth::user()->followers->count() }}
                                            متابعون
                                        </a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="col-md-9">

                            <div class="row">
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
                            </div>


                            @yield('contenttt')


                        </div>
                    </div>
                </div>
            </div>


            <div id="profile_pic_modal" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <form>
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3>تعديل الصورة الشخصية</h3>
                            </div>

                            <div class="modal-body">
                                <strong>إختر الصورة:</strong> <br><br>
                                <div class="row">
                                    <input type="file" id="upload">

                                    <br>
                                    <div class="text-center">
                                        <div id="upload-demo"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                <button type="button" id="save_crop" class="btn btn-primary">إعتماد الصورة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div> <!-- /container -->
    </section>

@endsection
@section('extraJS')
    <script src="{{ asset('/public/croppie/croppie.min.js')  }}"></script>
    <script>
        $(document).ready(function () {
            console.log("ready!");


            $(document).on('change', '#update_cover', function (a) {
                console.log('Hii');
                var iSize = ($('#update_cover')[0].files[0].size / 1024);
                var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];

                if (iSize / 1024 > 5 || $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    alert('يجب أن يكون حجم الملف الذي تم تحميله بحجم لا يزيد عن 5 ميغابايت.');
                    $(this).val("");
                } else {
                    $('#update_cover_form').submit();
                }
            });

            /* $(document).on('click', '#prev-profile', function (e) {
                 console.log('Hi')
             });*/
            $('#change-profile-pic').on('click', function (e) {
                $('#profile_pic_modal').modal({show: true});
            });

            $uploadCrop = $('#upload-demo').croppie({
                url: '{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}',
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });

            $('#upload').on('change', function () {

                var imageReader = new FileReader();
                imageReader.readAsDataURL($('#upload')[0].files[0]);
                //console.log($('#profile-pic')[0].files[0]);
                imageReader.onload = function (oFREvent) {
                    //console.log(oFREvent.target.result);
                    $uploadCrop.croppie('bind', {
                        url: oFREvent.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                };
                /*imageReader.readAsDataURL($('#upload')[0].files[0]);*/
            });

            $('#save_crop').on('click', function (e) {
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {

                    $.ajax({
                        url: "{{ url('/user/upload_avatar') }}",
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {"image": resp},
                        success: function (data) {
                            window.location.reload()
                        }
                    });
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
