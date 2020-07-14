<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/10/2017
 * Time: 1:17 PM
 */ ?>

@extends('layouts.ipanel')
@section('title', $title)
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
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{ $title }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="{{ url(route('roles.store')) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group form-md-line-input">
                                <input type="text" class="form-control" name="name" placeholder="أدخل إسم الدور">
                                <label for="form_control_1">الإســـم
                                    <span class="required">*</span>
                                </label>
                                <span class="help-block">admin, editor, manager</span>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label for="form_control_1">الصلاحيات</label>
                                <div class="md-checkbox">
                                    @if($permissions)
                                        @foreach($permissions as $permission)
                                            <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox1_{{$permission->id}}"
                                                       name="checkboxes1[]" value="{{ $permission->id }}"
                                                       class="md-check">
                                                <label for="checkbox1_{{$permission->id}}">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> {{$permission->name}} </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green">حفــــظ</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
@endsection

@section('jsplugins')
    <script src="{{ asset('public/back/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/back/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
            type="text/javascript"></script>
@endsection

@section('jspage')
    <script src="{{ asset('public/back/assets/pages/scripts/form-validation-md.min.js') }}"
            type="text/javascript"></script>
@endsection