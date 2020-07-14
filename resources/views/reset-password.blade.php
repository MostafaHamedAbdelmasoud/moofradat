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
    <section class="contact">
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


            <form action="{{ url('user/reset-password/post') }}" method="post">
                {{ csrf_field() }}
                <div class="row">

                    <input type="hidden" name="hash" value="{{ $hash }}">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label for="">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" required=""
                                   placeholder="البريد الإلكتروني">
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label for="">كلمة المرور الجديدة</label>
                            <input type="password" name="password" class="form-control" required=""
                                   placeholder="*********">
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label for="">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" name="re_password" class="form-control" required=""
                                   placeholder="*********">
                        </div>
                    </div>


                    <div class="col-lg-4 col-xs-12">
                        <button type="submit" class="btn btn-block btn-info"
                                style="background-color: #3597B0;border: solid 1px #3597B0;">إعادة التعيين
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </section>



@endsection