<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/24/2017
 * Time: 8:35 PM
 */ ?>
@extends('layouts.other')

@section('content')


    <!-- contact section  -->
    <!--<section class="contact register">-->
    <!--    <div class="container">-->
    <!--        <div class="page-header">-->
    <!--            <h3>{{ $title }}</h3>-->
    <!--        </div>-->


    <!--        @if(session('message'))-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="alert alert-block {{ session('type') }} fade in">-->
    <!--                        <button type="button" class="close" data-dismiss="alert"></button>-->
    <!--                        <span>{{ session('message') }}</span>-->

    <!--                        <br>-->
    <!--                        @if(count( $errors ) > 0)-->
    <!--                            @foreach ($errors->all() as $error)-->
    <!--                                <div>- {{ $error }}</div>-->
    <!--                            @endforeach-->
    <!--                        @endif-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        @endif-->

    <!--        <form action="{{ url('/forget-password/post') }}" method="post">-->
    <!--            {{ csrf_field() }}-->
    <!--            <div class="row">-->
    <!--                <div class="col-lg-6 col-xs-12">-->
    <!--                    <div style="background-color: #3597B0;padding: 55px; color: #ffffff" class="text-center">-->
    <!--                        <h3>هل نسيت كلمة المرور/البيانات الشخصية الخاصة بك ؟!</h3>-->
    <!--                        <hr>-->
    <!--                        <p>- في حال لم تتمكن من تذكر بيانات في موقع مفردات يمكنك إسترجاعها-->
    <!--                            عن طريق الصفحة الخاصة بـ-->
    <!--                            <a href="{{ url('/contact-us') }}" style="color: yellow">إتصل بنا</a>-->
    <!--                        </p>-->

    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="col-lg-6 col-xs-12">-->
    <!--                    <div class="form-group">-->
    <!--                        {{--<label for="">الاسم</label>--}}-->
    <!--                        <input type="email" name="email" class="form-control" required=""-->
    <!--                               placeholder="البريد الإلكتروني">-->
    <!--                    </div>-->
    <!--                    <hr>-->
    <!--                    <div class="row">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <button type="submit" class="btn btn-block btn-info"-->
    <!--                                    style="background-color: #3597B0;border: solid 1px #3597B0;">إرسال-->
    <!--                            </button>-->
    <!--                        </div>-->
    <!--                    </div>-->

    <!--                </div>-->
    <!--            </div>-->
    <!--        </form>-->


    <!--    </div>-->
    <!--</section>-->
























 <!-- contact section  -->
    <section class="contact register" style="text-align:center;">
        <div class="container"  style="
    background-color: white;
    min-height: 666px;
    border: solid 5px #3597b0;margin-top:60px;position:relative;text-align:center;padding:150px 0px 0px 0px;">
            
            
            
            <div class="page-header">
                <h3 style="text-align: center;color:black;"> هل نسيت كلمة المرور؟</h3>
            <h3 style="color:black; padding-right:35px">لا تقلق قم فقط بوضع الإيميل الخاص بك أدناه ليتم التحقيق </h3>
            </div>


           
            
            <form action="{{ url('/forget-password/post') }}" method="post">
            <!--<form action="{{ url('/user/register') }}" method="post" enctype="multipart/form-data">-->
                {{ csrf_field() }}
                <div class="row" style="margin: auto;width: 60%;">
                   

                    <div class="col-xs-12" >

                       
                        
                        <div class="form-group">
                            
                            <label class="form-group border-lable-flt">
                           <input type="email" name="email" class="form-control" required=""
                                   placeholder="البريد الإلكتروني">
                            <span style="color:black;">البريد الإلكتروني</span>
                            </label>
                            
                        </div>
                        
                        
                       
                        
                        
                        

                    </div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-md-12" style="width:100%;">
                        <button type="submit" class="btn btn-info" style="background-color: #3597B0;border: solid 1px #3597B0;width:30%">تحقق
                        </button>
                    </div>
                </div>
            </form>



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
            
        </div>
    </section>


















@endsection