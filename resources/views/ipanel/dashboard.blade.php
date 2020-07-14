<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/9/2017
 * Time: 8:49 AM
 */ ?>

@extends('layouts.ipanel')
@section('title', $title)
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


    <div class="row">
        @if(Auth::user()->can('manage_words'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="{{ url(route('words.index')) }}">
                    <div class="visual">
                        <i class="fa fa-language"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $words }}">0</span>
                        </div>
                        <div class="desc">عدد الكلمـــات</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_discharges'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="{{ url(route('discharges.index')) }}">
                    <div class="visual">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $discharges }}">0</span>
                        </div>
                        <div class="desc">عدد التصاريــــف</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_shortcuts'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="{{ url(route('shortcuts.index')) }}">
                    <div class="visual">
                        <i class="fa fa-cut"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $shortcuts }}">0</span>
                        </div>
                        <div class="desc">عدد الإختصــارات</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_idioms'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple-sharp" href="{{ url(route('idioms.index')) }}">
                    <div class="visual">
                        <i class="fa fa-cut"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $idioms }}">0</span>
                        </div>
                        <div class="desc">عدد المصطــلحات</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_slang'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{ url(route('slang.index')) }}">
                    <div class="visual">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $slang }}"></span>
                        </div>
                        <div class="desc">عدد الكلمات العامية</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_medical'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 yellow-haze" href="{{ url(route('medical.index')) }}">
                    <div class="visual">
                        <i class="fa fa-heartbeat"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $terms }}"></span>
                        </div>
                        <div class="desc">عدد المصطلحات الطبية</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_jobs'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green-dark" href="{{ url(route('jobs.index')) }}">
                    <div class="visual">
                        <i class="icon-bag"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $jobs }}"></span>
                        </div>
                        <div class="desc">عدد الوظائف</div>
                    </div>
                </a>
            </div>
        @endif
        @if(Auth::user()->can('manage_format'))
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 yellow" href="{{ url(route('format.index')) }}">
                    <div class="visual">
                        <i class="icon-bag"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="{{ $formats }}"></span>
                        </div>
                        <div class="desc">عدد شكل الكلمات</div>
                    </div>
                </a>
            </div>
        @endif
    </div>


    @if(Auth::user()->can('super_admin') && Auth::user()->can('show_logs'))
        <div class="row">
			<div class="col-lg-12 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-globe font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">تنبيهات</span>
                        </div>
					</div>
					<div class="portal-body">
						<form method="post" action="{{ route('ipanel.notice') }}">
						@csrf()
						<div class="form-group">
							<label for="notification">نص التنبيه</label>
							<textarea id="summernote" name="editordata"></textarea>
							
							<textarea hidden id="summernote2" name="editordata2"></textarea>

						</div>
						<button class="btn btn-primary makeRep"  type="submit">حفظ</button>
						</form>
					</div>
			</div>
		</div>
		
		
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-globe font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">العمليات</span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_1" class="active" data-toggle="tab"> أخر 10 عمليات </a>
                            </li>

                        </ul>
                    </div>
                    <div class="portlet-body">
                        <!--BEGIN TABS-->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_1">
                                <div class="scroller" style="height: 339px;" data-always-visible="1"
                                     data-rail-visible="0">
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
                                                                <div class="desc"> المستخدم <span
                                                                            class="label label-md label-success">{{ $log->user->name }}</span>
                                                                    {{ $log->log_message }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date" title="{{ $log->created_at }}" dir="ltr">
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
                        <!--END TABS-->
                    </div>

                </div>
                <!-- END PORTLET-->
            </div>
        </div>
    @endif
@endsection
@section('pagePlugins')
    <script src="{{ themeUrl('backend/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/counterup/jquery.waypoints.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ themeUrl('backend/assets/global/plugins/counterup/jquery.counterup.min.js') }}"
            type="text/javascript"></script>
@endsection
@section('pageScript')
    <script src="{{ themeUrl('backend/assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
@endsection

