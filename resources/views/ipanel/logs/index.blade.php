<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/7/2017
 * Time: 2:43 PM
 */
?>

@extends('layouts.ipanel')
@section('title', $title)

@section('')
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
@endsection
@section('content')

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


    <div class="col-lg-12 col-xs-12 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">

            <div class="portlet-body">
                <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                    <ul class="feeds">

                        @if($logs)
                            @foreach($logs as $log)
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">
                                                    <i class="fa fa-bell-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                       <span class="label label-sm label-success"> {{ $log->created_at }}
                                                                            </span> :::
                                                    {{ $log->log_message }} بواسطة :
                                                    <span class="label label-primary">{{ $log->user->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date" dir="ltr">
                                            <small>{{ $log->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>

            </div>
        </div>
        <!-- END PORTLET-->
    </div>


@endsection
@section('pagePlugins')
    <script src="{{ themeUrl('backend/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/clockface/js/clockface.js') }}"
            type="text/javascript"></script>

@endsection
@section('pageScript')
    <script src="{{ themeUrl('backend/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
@endsection


