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
    <section class="contact register section">
        <div class="container">
            <div class="page-header">
                <h3>{{ $title }}</h3>
            </div>


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
            
                <div class="row">
            <form action="{{ url('/user/login') }}" method="post">
                {{ csrf_field() }}
                    <div class="col-lg-6 col-xs-12">
                        <div style="background-color: #3597B0;padding: 55px; color: #ffffff" class="text-center">
                            <h1>تعليمات تسجيل الدخول</h1>
                            <hr>
                            <p>- في حال قمت بتسجيل مستخدم جديد ولم تقم بتفعيل عضويتك يمكنك فحص بريدك الإلكتروني والتفعيل
                                حسابك او عن طريق التواصل مع الإدارة
                                عن طريق الصفحة الخاصة بـ
                                <a href="{{ url('/contact-us') }}" style="color: yellow">إتصل بنا</a>
                            </p>

                            <p>
                                - ان كنت تريد ان تكون مميز وتحصل على علامة التوثيق
                                الخاصة بموقع مفردات يمكنك التواصل معنا عبر
                                <a href="{{ url('/verification-account') }}" style="color: yellow"> توثيق الحساب
                                    الشخصي</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            {{--<label for="">الاسم</label>--}}
                            <input type="text" name="email" class="form-control" required=""
                                   placeholder="البريد الإلكتروني/إسم المستخدم">
                        </div>

                        <div class="form-group">
                            {{--<label for="">الاسم</label>--}}
                            <input type="password" name="password" class="form-control" required=""
                                   placeholder="كلمة المرور">
                        </div>

                        <div class="row" style="padding-right: 35px">
                            <div class="col-md-6">
                                <input type="checkbox" name="remember" id="">
                                تذكرني
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('/forget-password') }}">نسيت كلمة المرور ؟</a>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-info"
                                        style="background-color: #3597B0;border: solid 1px #3597B0;">إرسال
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>


        </div>
    </section>



@endsection