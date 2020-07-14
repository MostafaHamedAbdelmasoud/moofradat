<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/7/2017
 * Time: 6:39 AM
 */
?>
@extends('layouts.login')
@section('title','إعادة كلمة المرور')
@section('content')

    <!-- BEGIN LOGIN FORM -->
    <form class="reset-form" action="{{ url(route('ipanel.login.submit')) }}" method="post">
        {{ csrf_field() }}
        <h3 class="form-title font-green">إعادة تعيين كلمة المرور</h3>
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
            <label class="control-label visible-ie8 visible-ie9">كلمة مرور</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="********" name="password" dir="ltr"/>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-circle btn-block green uppercase">إعادة تعيين</button>

        </div>
    </form>
    <!-- END LOGIN FORM -->
@endsection
