<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/26/2017
 * Time: 6:24 PM
 */ ?>

<!-- BEGIN SIDEBAR -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
        data-slide-speed="200" style="padding-top: 20px">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler">
                <span></span>
            </div>
        </li>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->

        <li class="nav-item start {{ setActive('ipanel/dashboard') }}">
            <a href="{{ url('ipanel/dashboard') }}" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">الرئيسية</span>
            </a>
        </li>


        @if(Auth::user()->can('super_admin') && (Auth::user()->can('add_users') || Auth::user()->can('edit_users') || Auth::user()->can('delete_users')))
            <li class="heading">
                <h3 class="uppercase">المستخدمين والصلاحيات</h3>
            </li>
            <li class="nav-item start {{ setActive('ipanel/users') }}">
                <a href="{{ url('ipanel/users') }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">إدارة المستخدمين</span>
                </a>
            </li>
        @endif


        @if(Auth::user()->can('add_role') || Auth::user()->can('edit_role') || Auth::user()->can('delete_role') || Auth::user()->can('edit_permission'))
            <li class="nav-item  {{ (Request::is('ipanel/roles*') || Request::is('ipanel/permissions*')) ? 'active open': '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-check"></i>
                    <span class="title">الأدوار والصلاحيات</span>
                    @if(Request::is('ipanel/roles*') || Request::is('ipanel/permissions*'))
                        <span class="selected"></span>
                    @endif
                    <span class="arrow {{ (Request::is('ipanel/roles*') || Request::is('ipanel/permissions*')) ? 'open': '' }}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item   {{ setActive('ipanel/roles') }}">
                        <a href="{{ url('ipanel/roles') }}" class="nav-link ">
                            <i class="icon-shield"></i>
                            <span class="title">إدارة الأدوار</span>
                        </a>
                    </li>
                    <li class="nav-item   {{ setActive('ipanel/permissions') }}">
                        <a href="{{ url('ipanel/permissions') }}" class="nav-link ">
                            <i class="icon-badge"></i>
                            <span class="title">إدارة الصلاحيات</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        @if(Auth::user()->can('manage_pages'))
            <li class="heading">
                <h3 class="uppercase">الصفحات</h3>
            </li>
            <li class="nav-item start {{ setActive('ipanel/pages') }}">
                <a href="{{ url('ipanel/pages') }}" class="nav-link nav-toggle">
                    <i class="fa fa-book"></i>
                    <span class="title">إدارة الصفحات</span>
                </a>
            </li>
        @endif


        @if(Auth::user()->can('manage_ads'))
            <li class="heading">
                <h3 class="uppercase">الاعلانات</h3>
            </li>
            <li class="nav-item start ">
                <a href="{{ url(route('adstype.index')) }}" class="nav-link nav-toggle">
                    <i class="fa fa-book"></i>
                    <span class="title">إدارة الفئات</span>
                </a>
            </li>
            <li class="nav-item start">
                <a href="{{ url(route('ads.index')) }}" class="nav-link nav-toggle">
                    <i class="fa fa-book"></i>
                    <span class="title">إدارة الإعلانات</span>
                </a>
            </li>
        @endif



        @if(Auth::user()->can('send_notification'))
            <li class="heading">
                <h3 class="uppercase">الإشعارات</h3>
            </li>
            <li class="nav-item start {{ setActive('ipanel/notification') }}">
                <a href="{{ url('ipanel/notification') }}" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>
                    <span class="title">إشعارات الهاتف</span>
                </a>
            </li>
        @endif



        @if(Auth::user()->can('manage_words') || Auth::user()->can('manage_shortcuts') || Auth::user()->can('discharges') || Auth::user()->can('manage_slang') || Auth::user()->can('manage_medical') || Auth::user()->can('manage_jobs') || Auth::user()->can('manage_format') || Auth::user()->can('manage_idioms'))
            <li class="heading">
                <h3 class="uppercase">أخرى</h3>
            </li>
            @if(Auth::user()->can('manage_words'))
                <li class="nav-item start {{ setActive('ipanel/words') }}">
                    <a href="{{ url('ipanel/words') }}" class="nav-link nav-toggle">
                        <i class="fa fa-language"></i>
                        <span class="title">إدارة المفردات</span>
                        @if(! Auth::user()->can('manage_words'))
                        
                        $wcount= \App\Word::where(['status' => 0 , '	added_by' , auth()->user()->id])->get()->count();
                        <span class="badge badge-danger">{{ $wcount }}</span>
                        
                        @endif
                        @php
                            $wcount= \App\Word::where('status',0)->get()->count();
                        @endphp
                        @if($wcount > 0)
                            <span class="badge badge-danger">{{ $wcount }}</span>
                        @endif
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('manage_discharges'))
                <li class="nav-item start {{ setActive('ipanel/discharges') }}">
                    <a href="{{ url('ipanel/discharges') }}" class="nav-link nav-toggle">
                        <i class="fa fa-hourglass-half"></i>
                        <span class="title">إدارة التصريفات</span>
                        @php
                            $dcount= \App\Discharges::where('status',0)->get()->count();
                        @endphp
                        @if($dcount > 0)
                            <span class="badge badge-danger">{{ $dcount }}</span>
                        @endif
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('manage_shortcuts'))
                <li class="nav-item start {{ setActive('ipanel/shortcuts') }}">
                    <a href="{{ url('ipanel/shortcuts') }}" class="nav-link nav-toggle">
                        <i class="fa fa-cut"></i>
                        <span class="title">إدارة الاختصارات</span>
                        @php
                            $scount= \App\Shortcut::where('status',0)->get()->count();
                        @endphp
                        @if($scount > 0)
                            <span class="badge badge-danger">{{ $scount }}</span>
                        @endif
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('manage_slang'))
                <li class="nav-item start {{ setActive('ipanel/slang') }}">
                    <a href="{{ url('ipanel/slang') }}" class="nav-link nav-toggle">
                        <i class="fa fa-globe"></i>
                        <span class="title">إدارة الكلمات العامة</span>
                        @php
                            $slcount= \App\Slang::where('status',0)->get()->count();
                        @endphp
                        @if($slcount > 0)
                            <span class="badge badge-danger">{{ $slcount }}</span>
                        @endif
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('manage_medical'))
                <li class="nav-item start {{ setActive('ipanel/medical') }}">
                    <a href="{{ url('ipanel/medical') }}" class="nav-link nav-toggle">
                        <i class="fa fa-heartbeat"></i>
                        <span class="title">إدارة المصطلحات الطبية</span>
                        @php
                            $mcount= \App\Medical::where('status',0)->get()->count();
                        @endphp
                        @if($mcount > 0)
                            <span class="badge badge-danger">{{ $mcount }}</span>
                        @endif
                    </a>
                </li>
            @endif


            @if(Auth::user()->can('manage_format'))
                <li class="nav-item start {{ setActive('ipanel/format') }}">
                    <a href="{{ url('ipanel/format') }}" class="nav-link nav-toggle">
                        <i class="icon-bag"></i>
                        <span class="title">إدارة شكل الكلمة</span>
                        @php
                            $fcount= \App\Format::where('status',0)->get()->count();
                        @endphp
                        @if($fcount > 0)
                            <span class="badge badge-danger">{{ $fcount }}</span>
                        @endif
                    </a>
                </li>
            @endif


            @if(Auth::user()->can('manage_idioms'))
                <li class="nav-item start {{ setActive('ipanel/idioms') }}">
                    <a href="{{ url('ipanel/idioms') }}" class="nav-link nav-toggle">
                        <i class="icon-bag"></i>
                        <span class="title">إدارةالمصطلحات</span>
                        @php
                            $icount= \App\Idioms::where('status',0)->get()->count();
                        @endphp
                        @if($icount > 0)
                            <span class="badge badge-danger">{{ $icount }}</span>
                        @endif
                    </a>
                </li>
            @endif


            @if(Auth::user()->can('manage_jobs'))
                <li class="nav-item start {{ setActive('ipanel/jobs') }}">
                    <a href="{{ url('ipanel/jobs') }}" class="nav-link nav-toggle">
                        <i class="icon-bag"></i>
                        <span class="title">إدارة الوظائف</span>
                    </a>
                </li>
            @endif

        @endif




        @if(Auth::user()->can('super_admin') && Auth::user()->can('edit_site_settings'))
            <li class="heading">
                <h3 class="uppercase">إعدادات</h3>
            </li>
            <li class="nav-item start {{ setActive('ipanel/settings') }}">
                <a href="{{ url('ipanel/settings') }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">إعدادات الموقع</span>
                </a>
            </li>
        @endif

        @if(Auth::user()->can('super_admin') && Auth::user()->can('show_logs'))
            <li class="nav-item start {{ setActive('ipanel/logs') }}">
                <a href="{{ url('ipanel/logs') }}" class="nav-link nav-toggle">
                    <i class="icon-eye"></i>
                    <span class="title">سجل العمليات</span>
                </a>
            </li>
        @endif

        {{-- <li class="nav-item start {{ setActive('ipanel/help') }}">
             <a href="{{ url('ipanel/help') }}" class="nav-link nav-toggle">
                 <i class="icon-info"></i>
                 <span class="title">مساعدة</span>
             </a>
         </li>--}}


    </ul>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
