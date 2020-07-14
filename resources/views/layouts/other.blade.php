<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 2:57 PM
 */ ?>
        <!doctype html>
<html lang="en" class="no-js">
<head>
    <!-- Set encoding to UTF-8-->
    <meta charset="UTF-8"/>

    <!-- Mobile friendly -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <title>{{ $name }} - {{ $title }}</title>
    <!-- Favicon -->
    <link rel="icon" href="favicon.png"/>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $description }}"/>
    <meta name="keywords" content="{{ $keywords }}"/>

    <!-- Open Graph Protocol Tags -->
    <meta property="ogp:title" content="{{ $name.' - '. $description}}"/>
    <meta property="ogp:type" content="website"/>
    <meta property="ogp:url" content="{{ $url }}"/>
    <meta property="ogp:image" content=""/>
    <meta property="ogp:decription" content="{{ $description }}"/>
    <meta property="ogp:site_name" content="{{ $name }}"/>


    <link rel="stylesheet" href="{{ themeUrl('frontend/css/bootstrap-arabic.css') }}"> <!-- CSS reset -->
    <link rel="stylesheet" href="{{ themeUrl('frontend/css/font-awesome.min.css') }}"> <!-- Resource style -->
    <link rel="stylesheet" href="{{ themeUrl('frontend/css/index.css') }}"> <!-- Resource style -->
    <link rel="stylesheet" href="{{ themeUrl('frontend/css/bootstrap-social.css') }}"> <!-- Resource style -->

    <Style>
    * {
font-family: 'cairo' !important;
    }
    .nav_buttons{
        background-color:white!important;
    }
    .nav_buttons:hover{
        background-color:#f5f5f5!important;
    }
    #Taqeemk{
        width:100%;
        margin:auto;
    }
    .footer_terms li{
        padding: 5px 0px 0px 0px;
    }
    footer{
        background-color:#26677e;
    }
    nav{
        background-color:#26677e;   
    }
    .border-lable-flt {
  display: block;
  position: relative;
}
.border-lable-flt label, .border-lable-flt > span {
  position: absolute;
  right: 0;
  top: 0;
  cursor: text;
  font-size: 100%;
  opacity: 1;
  -webkit-transition: all .2s;
          transition: all .2s;
  top: -.5em;
  right: 0.75rem;
  z-index: 3;
  line-height: 1;
  padding: 0 1px;
  color: turquoise;
}
.border-lable-flt label::after, .border-lable-flt > span::after {
  content: " ";
  display: block;
  position: absolute;
  background: white;
  height: 2px;
  top: 50%;
  left: -.2em;
  right: -.2em;
  z-index: -1;
}




.input-group .border-lable-flt {
  display: table-cell;
}
.input-group .border-lable-flt .form-control {
  border-radius: 0.25rem;
}
.input-group .border-lable-flt:not(:last-child), .input-group .border-lable-flt:not(:last-child) .form-control {
  border-bottom-right-radius: 0;
  border-top-right-radius: 0;
  border-right: 0;
}
.input-group .border-lable-flt:not(:first-child), .input-group .border-lable-flt:not(:first-child) .form-control {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
}

.contact .form-control:not(textarea) {
    height: 50px;
    border-radius: 0;
    border-color: black;
    padding: 32px 12px 
}

@media (min-width:1300px) {
    .dropMenu{
        margin-left:180px!important;
    }
}

    </Style>
    @yield('extraCss')
</head>

<!--<body style="background-color:white;">-->
<body style="background-color:white;">
<nav class="navbar navbar-inverse navbar-fixed-top text-center" style="z-index:99999999;background-color:#26677e;">
    <div class="container px-4">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#Taqeemk">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ url('/index') }}" class="navbar-brand">
                <img src="{{ asset('public/uploads/images/').'/'.$logo }}">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="Taqeemk">
            <ul class="nav navbar-nav" style="padding:0px 0px;padding-top: 12px">
                <li><a href="{{ url('words') }}">
                        {{--<i class="fa fa-language"></i>--}}
                        <span>الكلمات</span>
                    </a></li>

                <li><a href="{{ url('discharges') }}">
                        {{--<i class="fa fa-hourglass-half"></i>--}}
                        <span class="title">التصريفات</span>

                    </a>
                </li>
                
                <li><a href="{{ url('/formats') }}">
                        {{--<i class="fa fa-language"></i>--}}
                        <span class="title">شكل الكلمة</span>
                    </a></li>
                
                 <li><a href="{{ url('/shortcuts') }}">{{--<i class="fa fa-cut"></i>--}}
                        <span class="title">الاختصارات</span></a></li>    
                        
               
                        
                <li><a href="{{ url('/slang') }}">{{--<i class="fa fa-globe"></i>--}}
                        <span class="title">الكلمات العامية</span></a></li>

                <li><a href="{{ url('/medical') }}">{{--<i class="fa fa-heartbeat"></i>--}}
                        <span class="title">المصطلحات الطبية</span></a></li>
                
                <li><a href="{{ url('/idioms') }}">
                        {{--<i class="fa fa-language"></i>--}}
                        <span class="title"> المصطلحات التعبيرية</span>
                    </a></li>
                    
                    @if(Auth::check())
                    <!-- <li><a href="{{ url('/user/verify-account') }}">-->
                    <!--    {{--<i class="fa fa-language"></i>--}}-->
                    <!--    <span class="title">تفعيل الحساب</span>-->
                    <!--</a></li>-->
                    @else
                    <li ><a href="{{ url('/signup') }}" >
                        {{--<i class="fa fa-language"></i>--}}
                        <button type="button" class="btn btn-outline-info my-2 my-sm-0 bg-white nav_buttons" style="padding:4px 10px!important; margin:0px!important;">
                           <span style="color: #3597b0;"> أنشئ الحساب</span> 
                        </button>
                        <span class="title"></span>
                    </a></li>
                    <li><a href="{{ url('/login') }}">
                        {{--<i class="fa fa-language"></i>--}}
                        <button type="button" class="btn btn-outline-info my-2 my-sm-0 bg-white nav_buttons" style="padding:4px 10px!important; margin:0px!important">
                           <span style="color: #3597b0;">دخول</span> 
                        </button>
                    </a></li>
                    @endif
            </ul>

                    @if(Auth::check())
            <ul class="nav navbar-nav navbar-right profile-section" style="padding-top: 12px;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="inset">
                         <!--<a href="{{  url('/'.Auth::user()->username) }}">-->
                            <img src="{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}">
                            <!--</a>-->
                    </div>
                </a>

                <ul class="dropdown-menu dropMenu" style="background-color:#26677e;">
                        <li class="text-center">
                            <a href="{{  url('/'.Auth::user()->username) }}">
                                
                                <span class="title">{{ Auth::user()->name }}</span>
                                <br>
                                
                                <span class="title" dir="ltr">{{ '@'.Auth::user()->username }}</span>
                            </a>
                        </li>
                        <hr>
                        <!--<li class="text-center">-->
                        <!--    <a href="{{  url('/'.Auth::user()->username) }}">-->
                        <!--        <i class="fa fa-user"></i>-->
                        <!--        <span class="title">الملف الشخصي</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="text-center">
                            <a href="{{ url('user/profile/settings') }}">
                                <!--<i class="fa fa-pencil-square-o"></i>-->
                                <span class="title">تعديل الملف الشخصي</span>
                            </a>
                        <hr>
                        </li>
                        <li class="text-center">
                            <a href="{{ url('user/profile/activity') }}">
                                <!--<i class="fa fa-line-chart"></i>-->
                                <span class="title">إحصائيات الحساب</span>
                            </a>
                        <hr>
                        </li>
                        <li class="text-center">
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                                     document.getElementById('user-logout-form').submit();">
                                <!--<i class="fa fa-sign-out"></i>-->
                                <span class="title">تسجيل الخروج</span>
                            </a>

                            <form id="user-logout-form" action="{{ url('/user/logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </li>
                    <!--    <li class="text-center">-->
                    <!--        <a href="{{ url('/login') }}">-->
                    <!--            <i class="fa fa-user"></i>-->
                    <!--            <span class="title">تسجيل الدخول</span>-->
                    <!--        </a>-->
                    <!--    </li>-->
                    <!--    <li class="text-center">-->
                    <!--        <a href="{{ url('/signup') }}">-->
                    <!--            <i class="fa fa-user-plus"></i>-->
                    <!--            <span class="title">تسجيل مستخدم جديد</span>-->
                    <!--        </a>-->
                    <!--    </li>-->
                </ul>
            </ul>
        @endif
        </div>


    </div>
</nav>

<!--<div class="container" style="background-color:#f5f5f5">-->
@yield('content')
<!--</div>-->


<!-- footer  -->
<footer class="fixed-bottom">
    <div class="container">
        <div class="row ">
            <!-- logo and desc -->
            <div class="col-lg-6 col-sm-6 col-xs-12" >
             <h4 class="mof_footer">عن مفردات</h4>
             <p  class="mof_footer" style="font-size:18px;">تطبيق تعليمي بطريقة سهلة ومبتكرة .</p>
             <p  class="mof_footer" style="font-size:18px;">بحيث يسهل تعلم الكلمة وحفظها . </p>
             <div class="row" style="padding-top:40px;">
   <div class="col-lg-6 col-sm-6 col-xs-12 " >
     <a href="https://twitter.com/moofradat" class="app" target="_blank" data-toggle="tooltip" title="" data-original-title="حساب مفردات" aria-describedby="tooltip889379">
                                <!--<img src="https://moofradat.com/public/uploads/images/icon-twitter.svg" alt="" class="img-responsive">-->
                                <img src="https://moofradat.com/public/uploads/images/twitter.png" alt="" class="img-responsive">
                            </a>
</div>
       <div class="col-lg-6 col-sm-6 col-xs-12" style=" text-align: center">
    <a href="https://twitter.com/moofradat" class="app" target="_blank" data-toggle="tooltip" title="" data-original-title="حساب مفردات" aria-describedby="tooltip889379">
                                <!--<img src="https://moofradat.com/public/uploads/images/icon-insta.svg" alt="" class="img-responsive">-->
                                <img src="https://moofradat.com/public/uploads/images/insta.png" alt="" class="img-responsive">
                            </a>
</div>

</div>
            </div>

            <!-- footer links -->

            <div class="col-lg-6 col-sm-6 col-xs-12" style="border: 2px solid gainsboro;border-bottom: none;border-top: none;border-left: none;">
                <div class="footer-links">
                    <!--<div class="row">-->
                    <!--    <div class="col-md-offset-2 col-md-6 col-xs-6">-->
                            <ul class="list-unstyled footer_terms" style=" text-align: center;">
                             
                                <li><a href="{{ url('/terms') }}">شروط الخدمة</a></li>
                                <li><a href="{{ url('/contact-us') }}">إتصل بنا</a></li>
                                <li><a href="{{ url('/jobs') }}">الوظائف</a>    </li>
                                 @if(Auth::check())
                                 <li><a href="{{ url('/user/validate-account') }}">توثيق الحساب</a>    </li>
                                 @endif
                            </ul>
                    <!--    </div>-->
                        
                    <!--</div>-->
                </div>
                      <div class="row" style="padding-top:40px;">
   <div class="col-lg-6 col-sm-6 col-xs-12 " >
                            <a href="https://itunes.apple.com/sa/app/%D9%85%D9%81%D8%B1%D8%AF%D8%A7%D8%AA-%D8%A7%D9%84%D9%82%D8%A7%D9%85%D9%88%D8%B3-%D8%A7%D9%84%D8%A7%D9%81%D8%B6%D9%84-%D9%84%D9%84%D8%A5%D9%86%D8%AC%D9%84%D9%8A%D8%B2%D9%8A%D8%A9/id1190838073?mt=8" class="app" target="_blank">
                                <img src="https://moofradat.com/public/uploads/images/itunes.png" alt="" class="img-responsive">
                                <!--<i class="fab fa-instagram-square" style="color:white;font-size:32px"></i>-->
                            </a>
    </div>
       <div class="col-lg-6 col-sm-6 col-xs-12" style=" text-align: center;">
                           
        </div>
        
        </div>
            </div>
        </div>

        <!-- copyright  -->
        <p class="copyright">جميع الحقوق محفوظة <i class="fa fa-copyright"></i> {{ $name }} {{ date('Y') }}</p>
    </div>

    <!-- Modal -->
    <div id="requestModal" class="modal fade-scale" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">طلب ترجمة</h4>
                </div>
                <form action="{{ url('/sentMail') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">الاسم</label>
                                    <input type="text" name="sender_name" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="">البريد الالكتروني </label>
                                    <input type="email" name="sender_email" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="">نوع النص</label>
                                    <input type="text" name="type" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">النص </label>
                                    <textarea name="msg_content" rows="11" cols="80" class="form-control"></textarea>
                                    <span class="text-danger">* لا يتجاوز 500 حرف</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">إرسال</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">أغلاق</button>
                    </div>
            </div>
            </form>


        </div>
    </div>

</footer>


<script src="{{ themeUrl('frontend/js/jquery.min.js') }}"></script>
<script src="{{ themeUrl('frontend/js/bootstrap-arabic.min.js') }}"></script>
<script src="{{ themeUrl('frontend/js/index.js') }}"></script>
@yield('extraJS')
</body>
</html>
