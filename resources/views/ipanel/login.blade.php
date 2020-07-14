<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/7/2017
 * Time: 6:39 AM
 */
?>
@extends('layouts.login')
@section('title',$title)
@section('content')

    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{ url(route('ipanel.login.submit')) }}" method="post">
        {{ csrf_field() }}
        <h3 class="form-title font-green">تسجيل الدخول</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> رجاءاً إملأ الحقول. </span>
        </div>

        @if(session('message'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-block {{ session('type') }} fade in">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <span>{{ session('message') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                   placeholder="إسم المستخدم/البريد الالكتروني" name="username" dir="ltr"/></div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="********" name="password" dir="ltr"/></div>
        <div class="form-actions">
            <label class="rememberme check mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1"/>تذكرني
                <span></span>
            </label>
            <br>
            <button type="submit" class="btn btn-circle btn-block green uppercase">تسجيل الدخول</button>

        </div>
        <div class="create-account">
            <p>
                <a href="javascript:;" id="forget-password" class="uppercase">نسيت كلمة المرور؟</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->


    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="{{ url('/ipanel/email') }}" method="post">
        {{ csrf_field() }}
        <h3 class="font-green">نسيت كلمة المرور ؟</h3>
        <p> أدخل عنوان البريد الإلكتروني أدناه لإعادة تعيين كلمة المرور. </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="email" autocomplete="off"
                   placeholder="البريد الالكتروني"
                   name="email"/></div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn green btn-outline">للخلف</button>
            <button type="submit" class="btn btn-success uppercase pull-right">إرسال</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->

@endsection
