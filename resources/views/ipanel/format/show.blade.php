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
                          action="{{ url('ipanel/format/update',$format->id) }}">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group">
                                <label>إسم</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل إسم " name="noun"
                                           value="{{ (old('noun')) ? old('noun') : $format->noun }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>فعل</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل فعل " name="verb"
                                           value="{{ (old('verb')) ? old('verb') : $format->verb }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>صفة</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل صفة " name="adjective"
                                           value="{{ (old('adjective')) ? old('adjective') : $format->adjective }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>حال</label>
                                <div class="input-group">
                                                        <span class="input-group-addon input-circle-left">
                                                            <i class="fa fa-globe"></i>
                                                        </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل حال " name="adverb"
                                           value="{{ (old('adverb')) ? old('adverb') : $format->adverb }}">
                                </div>
                            </div>

                            <hr>

                            @if(Auth::user()->roles[0]->id != 3)
                                <div class="form-group">
                                    <label>الحالة</label>
                                    <select class="form-control" name="status">
                                        <option>إختر الحالة</option>
                                        <option value="0" {{ ($format->status == 0) ? 'selected="selected"' : '' }}>قيد
                                            الإنتظار
                                        </option>
                                        <option value="1" {{ ($format->status == 1) ? 'selected="selected"' : '' }}>
                                            مقبولة
                                        </option>
                                        <option value="2" {{ ($format->status == 2) ? 'selected="selected"' : '' }}>
                                            مرفوضة
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>سبب الرفض (إن وجد)</label>
                                            <div class="row">
                                                <div class="col-md-12">

                                                <textarea class="form-control"
                                                          name="note"
                                                          rows="6"> {{ (old('note')) ? old('note') : $format->note }}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if($format->note != null)
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>سبب الرفض (إن وجد)</label>
                                                <div class="row">
                                                    <div class="col-md-12">

                                                <textarea class="form-control"
                                                          name="note"
                                                          rows="6" readonly="readonly"> {{ $format->note }}</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif


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


