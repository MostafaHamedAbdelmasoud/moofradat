<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>

@extends('layouts.other')

@section('content')
    <!-- contact section  -->
    <section class="contact">
        <div class="container">
            <div class="page-header">
                <h3>{{ $title }}</h3>
            </div>


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


            <p>
                لطلب توثيق حسابك الرجاء التواصل معنا عبر هذه الصفحة فقط
            </p>
            <br><br>
            <form action="{{ url('/contactus') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label for="">الاسم</label>
                            <input type="text" name="sender_name" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="">البريد الالكتروني </label>
                            <input type="email" name="sender_email" class="form-control" required="">
                        </div>
                        <div class="form-group hidden hide">
                            {{--<label for="">الغرض من التواصل</label>--}}
                            <input type="text" name="msg_title" class="form-control" value="توثيق الحساب الشخصي">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label for="">الرسالة </label>
                            <textarea name="msg_content" rows="11" cols="80" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-block btn-info">إرسال</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
