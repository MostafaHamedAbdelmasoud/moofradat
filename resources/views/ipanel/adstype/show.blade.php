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
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5-rtl.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-summernote/summernote.css') }}"
          rel="stylesheet" type="text/css"/>
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
                        <i class="icon-settings"></i>تعديل شكل كلمة
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post"
                          action="{{ url('ipanel/adstype/update',$adstype->id) }}">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group">
                                <label>العنوان</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل العنوان " name="title"
                                           value="{{ $adstype->title }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>وصف قصير</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل وصف قصير " name="description"
                                           value="{{  $adstype->description }}">
                                </div>
                            </div>

                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-circle blue">حــــفظ</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>
@endsection

@section('pagePlugins')
    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"
            type="text/javascript"></script>

    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-summernote/summernote.min.js') }}"
            type="text/javascript"></script>
@endsection
@section('pageScript')
    <script src="{{ themeUrl('backend/assets/pages/scripts/components-editors.min.js') }}"
            type="text/javascript"></script>
@endsection


