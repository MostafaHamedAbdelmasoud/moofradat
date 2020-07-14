<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/24/2017
 * Time: 8:35 PM
 */ ?>
@extends('layouts.other')

@section('extraCss')
    <style>
    
    .border-lable-flt {
  display: block;
  position: relative;
}
.border-lable-flt label, .border-lable-flt > span {
  position: absolute;
  right: 0;
  top: 0;
  cursor: text;
  font-size: 100%;
  opacity: 1;
  -webkit-transition: all .2s;
          transition: all .2s;
  top: -.5em;
  right: 0.75rem;
  z-index: 3;
  line-height: 1;
  padding: 0 1px;
  color: turquoise;
}
.border-lable-flt label::after, .border-lable-flt > span::after {
  content: " ";
  color:red;
  display: block;
  position: absolute;
  background: white;
  height: 2px;
  top: 50%;
  left: -.2em;
  right: -.2em;
  z-index: -1;
}




.input-group .border-lable-flt {
  display: table-cell;
}
.input-group .border-lable-flt .form-control {
  border-radius: 0.25rem;
}
.input-group .border-lable-flt:not(:last-child), .input-group .border-lable-flt:not(:last-child) .form-control {
  border-bottom-right-radius: 0;
  border-top-right-radius: 0;
  border-right: 0;
}
.input-group .border-lable-flt:not(:first-child), .input-group .border-lable-flt:not(:first-child) .form-control {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
}

.contact .form-control:not(textarea) {
    height: 50px;
    border-radius: 0;
    border-color: black;
    padding: 32px 12px 
}
        .img-upload-btn {
            position: relative;
            overflow: hidden;
            padding-top: 95%;
            height:100%;
        }

        .img-upload-btn input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        .img-upload-btn i {
            position: absolute;
            height: 16px;
            width: 16px;
            top: 50%;
            left: 50%;
            margin-top: -8px;
            margin-left: -8px;
        }

        .btn-radio {
            position: relative;
            overflow: hidden;
        }

        .btn-radio input[type=radio] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
        #pass{
            position:relative;
        }
          #showEye{
            position:absolute;
            right:87%;
            top:40%;
            width:10%;
            cursor:pointer;
            border-right:solid 0.5px black;
        }: red;
        }
        /*.reg{*/
        /*    position:relative;*/
        /*}*/
        /*.picker img{*/
        /*    position:absolute;*/
        /*    top:0%;*/
        /*    right:50%;*/
            
        /*}*/
    </style>
@endsection
@section('content')


    <!-- contact section  -->
    <section class="contact register" style="text-align:center;padding:50px 0px">
        <div class="container reg"  style="
    background-color: white;
    min-height: 750;
    border: solid 5px #3597b0;margin-top:60px;position:relative;text-align:center;padding:60px 0px 30px 0px;">
            
            
<!--                          <div class="page-header">-->
<!--                <h3 style="-->
<!--    text-align: center;-->
<!--    color:black;-->
    
<!--"> قم بانشاء حسابك على <span style="color:#3597b0">موقع مفردات</span></h3>-->
<!--<p style="color:black; padding-right:35px">عندما تقوم بالتسجيل ستتمكن من اظافة كلمات</p>-->
<!--            </div>-->


                        <div class="row text-center picker" style="margin:auto">
                            <div class="col-md-4 text-center"></div>
                            <div class="col-md-4 text-center" style="margin-top:-100px;padding-right:100px;">
                                <div class="form-group text-center" >
                                    <div class="img-picker"></div>
                                </div>
                            </div>
                                <div class="col-md-4 text-center"></div>
                        </div>
                        
                        
 <div class="col-xs-12" style="width:50%;text-align:center; ">

                        
                        
                        <h3 style="
    text-align: center;
    color:black;
    
"> قم بانشاء حسابك على <span style="color:#3597b0">موقع مفردات</span></h3>
<p style="color:black; padding-right:35pxك">عندما تقوم بالتسجيل ستتمكن من اظافة كلمات</p>
      
                    </div>
            
             <!--<div class="img-picker picker" style="width:40%;"></div>-->


            @if(session('message'))
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

            <form action="{{ url('/user/register') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row" style="margin: auto;width: 100%;">
                   
                    
                   
                    
                    <!--<div class="form-group text-center">-->
                    <!--            <p>الصورة الشخصية</p>-->
                    <!--                <div class="img-picker"></div>-->
                    <!--            </div>-->
                        {{--<div class="form-group">
                            --}}
                            {{--<label for="av">الصورة الشخصية</label>--}}
                            {{--
                            <input  type="file" name="avatar" id="av" class="form-control" required="">
                        </div>--}} 
                        
                        
                        
                         <div class="row text-center">
                    
                     <div class="col-md-12 text-right" >
                    
                    <div class="col-md-5 text-right" >
                          
<!--                           <h3 style="-->
<!--    text-align: center;-->
<!--    color:black;-->
    
<!--"> قم بانشاء حسابك على <span style="color:#3597b0">موقع مفردات</span></h3>-->
<!--<p style="color:black; padding-right:0px;text-align:center;">عندما تقوم بالتسجيل ستتمكن من اظافة كلمات</p>-->
            <!--</div>-->

                        
                  <!--<div class="page-header">-->
<!--                <h3 style="-->
<!--    text-align: center;-->
<!--    color:black;-->
    
<!--"> قم بانشاء حسابك على <span style="color:#3597b0">موقع مفردات</span></h3>-->
<!--<p style="color:black; padding-right:35px">عندما تقوم بالتسجيل ستتمكن من اظافة كلمات</p>-->
            <!--</div>-->
                            
                        {{--<div class="form-group">
                            --}}
                            {{--<label for="av">الصورة الشخصية</label>--}}
                            {{--
                            <input  type="file" name="avatar" id="av" class="form-control" required="">
                        </div>--}}  
                        
                        
                        
                        <br>
                        <div class="form-group">
                            
                             <label  class="form-group border-lable-flt ">
                            <input type="text" name="full_name" class="form-control" required="" placeholder="الإسم بالكامل" value="{{ old('full_name') }}">
                            <span style="color:black;">الاسم الكامل</span>
                            </label>
                            
                        </div>
                        
                        
                        
                           <div class="form-group">
                            <label class="form-group border-lable-flt">
                  <input type="text" name="username" class="form-control" required=""
                                   placeholder="  إسم المستخدم   " value="{{ old('username') }}">
                                   
                                   <span style="color:black;"> إسم المستخدم   </span>

                            </label>
                            
                            
                        </div>
                        
                    
                        
                        
                        
                        <div class="form-group">
                            
                            
                             <label class="form-group border-lable-flt">
                        <input type="email" name="email" class="form-control" required="" placeholder="البريد الإلكتروني" value="{{ old('email') }}">
                                   <span style="color:black;">البريد الإالكتروني</span>
                            </label>
                            
                            
                        </div>
                        
                        
                        
                        
                        <div class="form-group">
                            
                            
                             <label class="form-group border-lable-flt">
                    <input id="pass" type="password" name="password" class="form-control" required=""placeholder="كلمة المرور"data-toggle="tooltip" title="كلمة المرور يجب ان تكون ثمان احرف وأرقام.">
                               <span style="color:black;">كلمة المرور </span>
                                 <p id="showEye" style="color:black;">إظهار</p>

                            </label>
                            
                         
                        </div>
                        
                        
                        
                        
                        
                        
                    <!--</div>-->
                    
                    
                    
                    </div>
                    
                     <div class="col-md-2" ></div>
                    
                     <div class="col-md-5" >
                    
                     <div class="form-group">
                         
                         <label class="form-group border-lable-flt">
                    <input type="text" name="bio" class="form-control" required=""
                                   placeholder=" النبذة التعريفية  ">    
                                   <span style="color:black;"> النبذة التعريفية </span>

                            </label>
                            
                           
                        </div>
                        
                        
                        
                        
                        <div class="form-group">
                            <label class="form-group border-lable-flt">
                   <input type="date" name="dof" class="form-control" required=""
                                   placeholder=" تاريخ الميلاد   ">
                                   
                                   <span style="color:black;"> تاريخ الميلاد  </span>

                            </label>
                            
                            
                            
                        </div>
                        
                        
                         <div class="form-group">
                            <label class="form-group border-lable-flt">
                  <input type="text" name="personalWebsite" class="form-control" required=""
                                   placeholder="  الموقع الإلكترونى   ">
                                   
                                   <span style="color:black;"> الموقع الإلكتروني   </span>

                            </label>
                            
                            
                        </div>
                        
                        
                         <div class="form-group">
                            
                             <label class="form-group border-lable-flt">
                                 
                  <input type="text" name="locale" class="form-control" required=""
                                   placeholder="الموقع الجغرافي  ">
                                   
                                   <span style="color:black;"> الموقع الجغرافي   </span>

                            </label>
                            
                            
                        </div>
                        
                        
                    </div>
                    
                    
                   
                        
                        
                        
                        
                    
                    
                </div>
                </div> <!-- -->
                </div>
                
                <br>
                <div class="row text-center">
                    
                  <!--    <div class="col-md-12" style="width:100%;margin-bottom:20px;" >-->
                  <!--      <div class="form-group" style="width:50%;margin:auto;">-->
                            
                  <!--           <label class="form-group border-lable-flt">-->
                                 
                  <!--<input type="text" name="locale" class="form-control" required=""-->
                  <!--                 placeholder="الموقع الجغرافي  ">-->
                                   
                  <!--                 <span style="color:black;"> الموقع الجغرافي   </span>-->

                  <!--          </label>-->
                            
                            
                  <!--      </div>-->
                        
                  <!--  </div>-->
                    
                    
                    <div class="col-md-12" style="width:100%;margin-bottom:20px;" >
                        <div class="form-group" style="width:50%;margin:auto;">
                            
                             <input id="terms" checked type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            أنا أقر و أوافق على 
                            <a href={{ url('https://moofradat.com/terms') }}>الشروط والأحكام</a>
                        </label>
                            
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-12" style="width:100%;">
                        <button type="submit" class="btn btn-info" style="background-color: #3597B0;border: solid 1px #3597B0;width:50%;padding:10px 0px">إرسال
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </section>



@endsection
@section('extraJS')
    <script>
        (function ($) {

            $.fn.imagePicker = function (options) {

                // Define plugin options
                var settings = $.extend({
                    // Input name attribute
                    name: "",
                    // Classes for styling the input
                    class: "form-control btn btn-default btn-block",
                    // Icon which displays in center of input
                    icon: "glyphicon glyphicon-plus"
                }, options);

                // Create an input inside each matched element
                return this.each(function () {
                    $(this).html(create_btn(this, settings));
                });

            };

            // Private function for creating the input element
            function create_btn(that, settings) {
                // The input icon element
                // var picker_btn_icon = $('<i class="' + settings.icon + '"></i>');
            var picker_btn_icon = $("<img src='{{ asset('public/uploads/images/guest.jpg') }}' width='150px' height='130px' >");
                // The actual file input which stays hidden
                var picker_btn_input = $('<input type="file" name="' + settings.name + '" />');

                // The actual element displayed
                var picker_btn = $('<div class="' + settings.class + ' img-upload-btn" style="height: 180px;border-radius: 70%;width: 200px;"></div>')
                    .append(picker_btn_icon)
                    .append(picker_btn_input);

                // File load listener
                picker_btn_input.change(function () {
                    if ($(this).prop('files')[0]) {
                        // Use FileReader to get file
                        var reader = new FileReader();

                        // Create a preview once image has loaded
                        reader.onload = function (e) {
                            var preview = create_preview(that, e.target.result, settings);
                            $(that).html(preview);
                        }

                        // Load image
                        reader.readAsDataURL(picker_btn_input.prop('files')[0]);
                    }
                });

                return picker_btn
            };

            // Private function for creating a preview element
            function create_preview(that, src, settings) {

                // The preview image
                var picker_preview_image = $('<img src="' + src + '" class="img-responsive img-rounded" />');

                // The remove image button
                var picker_preview_remove = $('<button class="btn btn-link"><small>إزالة</small></button>');

                // The preview element
                var picker_preview = $('<div class="text-center"></div>')
                    .append(picker_preview_image)
                    .append(picker_preview_remove);

                // Remove image listener
                picker_preview_remove.click(function () {
                    var btn = create_btn(that, settings);
                    $(that).html(btn);
                });

                return picker_preview;
            };

        }(jQuery));

        $(document).ready(function () {
            $('.img-picker').imagePicker({name: 'avatar'});
             $('#showEye').click(function(){
                if($("#pass").attr('type') == "text"){
                    $('#pass').attr('type', 'password');
                    $("#showEye").html('إظهار')
                }
                else{
                    $('#pass').attr('type', 'text');
                    $("#showEye").html('إخفاء')
                }
                // $("#pass").attr('type') == "text"? $('#pass').attr('type', 'password') : $('#pass').attr('type', 'text');
            });
        })
    </script>
@endsection