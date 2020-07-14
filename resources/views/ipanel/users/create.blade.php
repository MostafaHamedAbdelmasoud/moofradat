<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/10/2017
 * Time: 1:17 PM
 */ ?>


@extends('layouts.ipanel')
@section('title', $title)
@section('pagePlugin')
@endsection
@section('content')


    @if(session('message'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-block {{ session('type') }} fade in">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <h4 class="alert-heading">{{ session('message') }}</h4>
                    @if (isset($errors) && count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif




    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-users"></i>إضافة مستخدم جديد
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" enctype="multipart/form-data"
                          action="{{ url(route('users.store')) }}">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group">
                                <label>إسم المتسخدم</label>
                                <div class="input-group">
                                     <span class="input-group-addon input-circle-left">
                                       <i class="fa fa-envelope"></i>
                                     </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="إسم المستخدم" name="username" value="{{ old('username') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>البريد الالكتروني</label>
                                <div class="input-group">
                                     <span class="input-group-addon input-circle-left">
                                       <i class="fa fa-envelope"></i>
                                     </span>
                                    <input type="email" class="form-control input-circle-right"
                                           placeholder="البريد الالكتروني" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>الاسم الكامل</label>
                                <div class="input-group">
                                     <span class="input-group-addon input-circle-left">
                                       <i class="fa fa-envelope"></i>
                                     </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="الاسم الكامل" name="full_name" value="{{ old('full_name') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>كلمة المرور</label>
                                        <div class="input-group">
                                     <span class="input-group-addon input-circle-left">
                                       <i class="fa fa-lock"></i>
                                     </span>
                                            <input type="password" class="form-control input-circle-right"
                                                   placeholder="******" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>إعاداة كلمة المرور</label>
                                        <div class="input-group">
                                     <span class="input-group-addon input-circle-left">
                                       <i class="fa fa-lock"></i>
                                     </span>
                                            <input type="password" class="form-control input-circle-right"
                                                   placeholder="******" name="re_password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الأدوار</label>
                                        <select class="form-control" name="role">
                                            <option>إختر الدور</option>
                                            @if($roles)
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ (old('role') == $role->id) ? 'selected="selected"':''}}>{{ $role->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile1">الصورة الشخصية</label>
                                        <input type="file" name="avatar">
                                        <p class="help-block"> أقصى حد لحجم الصورة 2MB. قم برفع ملفات png/jpg. </p>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>حالة المستخدم</label>
                                        <select class="form-control" name="verifed">
                                            <option value="0" {{ (old('verifed') == 0) ? 'selected="selected"' : '' }}>
                                                غير فعال
                                            </option>
                                            <option value="1" {{ (old('verifed') == 1) ? 'selected="selected"' : '' }}>
                                                فعال
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>توثيق الحساب الشخصي</label>
                                        <select class="form-control" name="blue_mark">
                                            <option value="0" {{ (old('blue_mark') == 0) ? 'selected="selected"' : '' }}>
                                                لا
                                            </option>
                                            <option value="1" {{ (old('blue_mark') == 1) ? 'selected="selected"' : '' }}>
                                                نعم
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-circle blue">حــــفظ المستخدم</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>
@endsection
@section('pagePlugins')
@endsection
@section('pageScript')
@endsection

