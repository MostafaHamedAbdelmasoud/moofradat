<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/26/2017
 * Time: 9:40 AM
 */ ?>
        <!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>لوحة التحكم - @yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css') }}"
          rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @yield('pagePlugin')
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ themeUrl('backend/assets/global/css/components-md-rtl.min.css') }}" rel="stylesheet"
          id="style_components" type="text/css"/>
    <link href="{{ themeUrl('backend/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet') }}" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->


    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ themeUrl('backend/assets/layouts/layout/css/layout-rtl.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ themeUrl('backend/assets/layouts/layout/css/themes/default-rtl.min.css') }}" rel="stylesheet"
          type="text/css"
          id="style_color"/>
    <link href="{{ themeUrl('backend/assets/layouts/layout/css/custom-rtl.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->


    <link rel="shortcut icon" href="favicon.ico"/>
    
    <!--for notice-->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md">
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="">
                    <img src="{{ asset('public/uploads/images/'.$logo) }}" alt="logo"/> </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle"
                                 src="{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}"/>
                            <span class="username username-hide-on-mobile"> {{ Auth::user()->name }} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ url('ipanel/profile') }}">
                                    <i class="icon-user"></i> صفحتي الشخصية </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->

                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown">

                        {{-- <a class="dropdown-toggle logout-user mt-sweetalert"
                            data-title="هل تريد تسجيل الخروج؟"
                            data-message="لقد قمت بضغط على زر تسجيل الخروج."
                            data-type="info" data-show-confirm-button="true"
                            data-confirm-button-class="btn-success"
                            data-show-cancel-button="true"
                            data-cancel-button-class="btn-default"
                            data-close-on-confirm="false"
                            data-confirm-button-text='نعم, سجل خروجي.'
                            data-cancel-button-text='لا, اود البقاء.'
                            data-popup-title-success="شكراً لك."
                            data-popup-message-success="سيتم تسجيل خروجك خلال بضع ثواني. طاب يومك.">
                             <i class="icon-power"></i>
                         </a>--}}
                        <a class="dropdown-toggle logout-user">
                            <i class="icon-power"></i>
                        </a>
                    </li>
                    <!-- END QUICK SIDEBAR TOGGLER -->

                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"></div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            @include('includes.sidebar')
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->

                <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="{{ url('ipanel/dashboard') }}">لوحة التحكم</a>
                            <i class="fa fa-angle-left"></i>
                        </li>
                        <li>
                            <span>@yield('title')</span>
                        </li>
                    </ul>

                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <h1 class="page-title"> @yield('title')
                    <small>@yield('subTitle')</small>
                </h1>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
                <!-- BEGIN CONTENT -->
            @yield('content')
            <!-- END CONTENT -->
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer" style="float: left; direction: ltr">
        <div class="page-footer-inner"> 2020&copy; All rights reserved moofradat 
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>

<!--[if lt IE 9]>
<script src="{{ themeUrl('backend/assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/excanvas.min.js') }}"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/ie8.fix.min.js') }}"></script>
<![endif]-->


<!-- BEGIN CORE PLUGINS -->
<script src="{{ themeUrl('backend/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"
        type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
@yield('pagePlugins')
<script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
        type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ themeUrl('backend/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->
@yield('pageScript')
<script src="{{ themeUrl('backend/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->


<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ themeUrl('backend/assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ themeUrl('backend/assets/layouts/global/scripts/quick-sidebar.min.js') }}"
        type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

@yield('jsCode')

<script>
    $(document).ready(function () {
        $('.logout-user').click(function () {
            console.log('logout clicked!');
            swal({
                    title: "تسجيل الخروج!",
                    text: "لقد قمت بضغط على زر تسجيل الخروج.",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "نعم, سجل خروجي.",
                    cancelButtonText: "لا, اود البقاء",
                    closeOnConfirm: false
                },
                function () {
                    swal("شكراً لك!", "سيتم تسجيل خروجك خلال بضع ثواني. طاب يومك.", "success");
                    $logoutUrl = '{{ url(route('ipanel.logout')) }}';

                    setTimeout(function () {
                        // Do something after 1 second
                        window.location.href = $logoutUrl;
                    }, 3000);

                });
        });


        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
            
            console.log($('#summernote2'));
            
$('#summernote').on('summernote.keydown', function(we, e) {

            var plainText = $($("#summernote").summernote("code")).text();
            console.log(plainText.text);
            // console.log("kkffkkff");
                
            $('#summernote2').val(plainText);
    // alert("Test");
    // e.which is which key, e.g. 13 == enter
});
        // $("#summernote").keydown(function(){
            // var plainText = $($("#summernote").summernote()).text();
            // console.log(plainText);
            // console.log("kkffkkff");
                
            // $('#summernote2').val(plainText);
        // });
    });
  </script>
</body>

</html>

