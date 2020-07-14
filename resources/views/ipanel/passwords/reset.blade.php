<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/11/2017
 * Time: 9:25 AM
 */ ?>

@extends('layouts.login')
@section('title','إعادة تعيين كلمة المرور')
@section('content')

    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form action="{{ url('/ipanel/reset') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <h3 class="font-green">إعادة كلمة المرور !</h3>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <input class="form-control placeholder-no-fix" type="email" autocomplete="off"
                   placeholder="البريد الالكتروني"
                   name="email"/>
            @if ($errors->has('email'))
                <span class="help-block">
                                        <strong>حقل البريد الالكتروني إجباري</strong>
                                    </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="كلمة المرور"
                   name="password"/>
            @if ($errors->has('password'))
                <span class="help-block">
                                        <strong>حقل كلمة المرور إجباري</strong>
                                    </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="إعادة كلمة المرور"
                   name="password_confirmation"/>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
            @endif
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-block btn-success uppercase pull-right">إعادة تعيين كلمة المرور
            </button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->


@endsection

