<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/10/2017
 * Time: 1:15 PM
 */
?>


@extends('layouts.ipanel')
@section('title', $title)
@section('pagePlugin')
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5-rtl.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-summernote/summernote.css') }}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}"
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
                        <i class="icon-settings"></i> تعديل الإعدادت العامة للموقع
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" enctype="multipart/form-data"
                          action="{{ url('ipanel/settings/update/1') }}">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group">
                                <label>إسم الموقع</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل إسم الموقع" name="title"
                                           value="{{ $setting->site_title }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>وصف الموقع</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل وصف الموقع" name="description"
                                           value="{{ $setting->site_description }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>الكلمات المفتاحية </label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل وصف الموقع" name="keywords" data-role="tagsinput"
                                           value="{{ $setting->site_keywords }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>رابط الموقع</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-link"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل رابط الموقع" name="url" value="{{ $setting->site_url }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>شعار الموقع</label>
                                        <input type="file" name="logo">
                                        <p class="help-block text-info"> أقصى حد لحجم الصورة 2MB. ينصفح بعرض 45 لشعار
                                            الموقع. </p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('public/uploads/images').'/'.$setting->site_logo }}"
                                             height="45px">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>البريد الالكتروني للموقع</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-envelope-o"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل بريد الكتروني الموقع" name="email"
                                           value="{{ $setting->site_email }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label>رابط التطبيق في متجر جوجل</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-link"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل رابط التطبيق في متجر جوجل" name="android_app"
                                    value="{{  $setting->android_app }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>رابط التطبيق في متجر ابل</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-link"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل رابط التطبيق في متجر ابل" name="ios_app"
                                    value="{{  $setting->ios_app }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label>نص الفوتر</label>
                                <div class="input-group">
                                    <textarea class="summernote" id="summernote_1"
                                              name="footer_text"> {{ $setting->site_footer_text }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-circle blue">حــــفظ الإعـــدادات</button>
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

    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/typeahead/handlebars.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}"
            type="text/javascript"></script>
@endsection
@section('pageScript')
    <script src="{{ themeUrl('backend/assets/pages/scripts/components-editors.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}"
            type="text/javascript"></script>
@endsection


@section('jsCode')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 150,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
        });
    </script>
@endsection