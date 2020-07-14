@extends('layouts.other')

{{--@section('extraCss')
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5-rtl.css') }}"
          rel="stylesheet" type="text/css"/>
@endsection--}}


<!-- 1. Add latest jQuery and fancybox files -->

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css"/>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>



@section('content')


    <!-- contact section  -->
    <section class="contact">
        <div class="container">
            <div class="page-header">
                <h3>{{ $title }}</h3>
            </div>

            <div class="row">
                @if(session('message'))
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-block {{ session('type') }} fade in">
                                <button type="button" class="close" data-dismiss="alert"></button>
                                <span>{{ session('message') }}</span>

                                <br>
                                @if(count( $errors ) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div>- {{ $error }}</div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-sm-3"><!--left col-->


                    <div class="text-center">
                        <a data-fancybox="gallery" href="{{ asset('public/uploads/avatar/'.$user->avatar) }}">
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="avatar img-circle img-thumbnail" alt="avatar" id="avatar">
                        </a>
                        <br><br>
                        @if(Auth::check())
                            @if(Auth::user()->roles[0]->id == 3)
                                @if(Auth::user()->id != $user->id)
                                    @if(Auth::user()->followings()->where('leader_id', $user->id)->get()->count() > 0)
                                        <button class="btn btn-danger btn-block btn-lg"
                                                onclick="event.preventDefault();
                                                     document.getElementById('follow-form').submit();">
                                            إلغاء المتابعة
                                        </button>
                                        <form id="follow-form"
                                              action="{{ url('/'.$user->username.'/unfollow') }}"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @else
                                        <button class="btn btn-success btn-block btn-lg"
                                                onclick="event.preventDefault();
                                                     document.getElementById('follow-form').submit();">
                                            متابعة
                                        </button>
                                        <form id="follow-form"
                                              action="{{ url('/'.$user->username.'/follow') }}"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                @else
                                    <button class="btn btn-success btn-block btn-lg"
                                            onclick="window.location.href='{{ url('/ipanel') }}'">
                                        إضافة كلمة/مصطلح جديد
                                    </button>
                                @endif
                            @endif
                        @endif
                    </div>
                    <hr>
                    <br>

                    <div>


                        <h3>{{ $user->name }}

                            @if($user->blue_mark == 1)
                                <i class="fa fa-check-circle" style="color: #3597B0" data-toggle="tooltip"
                                   title="هذا الحساب موثّق"></i>
                            @endif
                        </h3>

                        <a href="{{ url('/'.$user->username) }}">
                            <small dir="ltr">{{ '@'.$user->username }}</small>
                        </a>
                        <br>
                        <br>
                        <p>{{ $user->bio }}</p>

                        <br><br>
                        <span>
                            <i class="fa fa-map-marker"></i>
                            {{ (isset($user->location)) ? $user->location : 'لم يتم تحديدها' }}
                        </span>
                        <br>

                        @if(isset(Auth::user()->website))
                            <span>
                             <i class="fa fa-external-link"></i>
                                <a href="{{ Auth::user()->website }}">{{ Auth::user()->website }}</a>
                         </span>
                        @endif

                        <br><br>
                        <ul class="list-group">
                            <li class="list-group-item text-right"><span
                                        class="pull-left"><strong>متابعون</strong></span>
                                <a href="Javascript:void(0);" data-toggle="modal"
                                   data-target="#userFollowers">{{ $user->followers->count() }}</a>
                            </li>
                            <li class="list-group-item text-right"><span
                                        class="pull-left"><strong>متابَعون</strong></span>
                                <a href="Javascript:void(0);" data-toggle="modal"
                                   data-target="#userFollowing">{{ $user->followings->count() }}</a>
                            </li>
                        </ul>

                    </div>

                </div><!--/col-3-->
                <div class="col-sm-9">
                    <ul class="nav nav-tabs" style="list-style-type:none;">
                        <li class="active"><a data-toggle="tab" href="#messages">قيد المراجعة</a></li>
                        <li><a data-toggle="tab" href="#home">تم قبولها</a></li>
                        <li><a data-toggle="tab" href="#settings">تم رفضها</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane" id="home">
                            <hr>

                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الكلمة</th>
                                    <th scope="col">القسم</th>
                                    <th scope="col">الحالة</th>
                                    {{--<th scope="col">الأوامر</th>--}}
                                </tr>
                                </thead>

                                @if($words_1->count() > 0 || $discharges_1->count() > 0 || $shortcuts_1->count() > 0 || $slang_1->count() > 0 || $terms_1->count() > 0 || $formats_1->count() > 0 || $idioms_1->count() > 0)
                                    <tbody>
                                    @foreach($words_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الكلمات
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($discharges_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                التصريفات
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($shortcuts_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الإختصارات
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($slang_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الكلمات العامة
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($terms_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                المصطلحات الطبية
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($formats_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                شكل الكلمة
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($idioms_1 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                المصطلحات
                                            </td>
                                            <td>
                                                <span class="label label-success">مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif

                            </table>

                            <hr>
                        </div><!--/tab-pane-->
                        <div class="tab-pane active" id="messages">

                            <h2></h2>

                            <hr>
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الكلمة</th>
                                    <th scope="col">القسم</th>
                                    <th scope="col">الحالة</th>
                                </tr>
                                </thead>

                                @if($words_0->count() > 0 || $discharges_0->count() > 0 || $shortcuts_0->count() > 0 || $slang_0->count() > 0 || $terms_0->count() > 0 || $formats_0->count() > 0 || $idioms_0->count() > 0)
                                    <tbody>
                                    @foreach($words_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الكلمات
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($discharges_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                التصريفات
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($shortcuts_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الإختصارات
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($slang_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الكلمات العامة
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($terms_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                المصطلحات الطبية
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($formats_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                شكل الكلمة
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($idioms_0 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                المصطلحات
                                            </td>
                                            <td>
                                                <span class="label label-default">قيد الإنتظار</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif
                            </table>


                        </div><!--/tab-pane-->
                        <div class="tab-pane" id="settings">


                            <hr>
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الكلمة</th>
                                    <th scope="col">القسم</th>
                                    <th scope="col">الحالة</th>
                                </tr>
                                </thead>

                                @if($words_2->count() > 0 || $discharges_2->count() > 0 || $shortcuts_2->count() > 0 || $slang_2->count() > 0 || $terms_2->count() > 0 || $formats_2->count() > 0 || $idioms_2->count() > 0)
                                    <tbody>
                                    @foreach($words_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الكلمات
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($discharges_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                التصريفات
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($shortcuts_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الإختصارات
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($slang_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                الكلمات العامة
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($terms_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                المصطلحات الطبية
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($formats_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                شكل الكلمة
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach($idioms_2 as $w)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><strong>{{ $w->word }}</strong></td>
                                            <td>
                                                المصطلحات
                                            </td>
                                            <td>
                                                <span class="label label-danger">مرفوض</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif

                            </table>


                        </div>

                    </div><!--/tab-pane-->

                    {{-- <div class="row">
                         <div class="col-md-12">
                             <h3>إضافة كلمات/مصطلحات جديدة</h3>
                         </div>
                         <br>


                         <button class="btn btn-success" data-toggle="modal" data-target="#addRequest">
                             إضافة كلمة/مصطلح جديد
                         </button>

                         --}}{{--  <div class="col-md-12" style="padding: 10px;">
                               <button class="btn btn-success" data-toggle="modal" data-target="#words">
                                   إضافة كلمة جديدة
                               </button>
                               <button class="btn btn-warning" data-toggle="modal" data-target="#discharges">
                                   إضافة تصريف جديد
                               </button>
                               <button class="btn btn-default" data-toggle="modal" data-target="#medical">
                                   إضافة مصطلح طبي جديد
                               </button>
                               <button class="btn btn-danger" data-toggle="modal" data-target="#shortcuts">
                                   إضافة إختصار جديد
                               </button>
                               <button class="btn btn-primary" data-toggle="modal" data-target="#slang">
                                   إضافة كلمة عامة جديدة
                               </button>
                           </div>

                           <div class="col-md-12" style="padding: 10px;">
                               <button class="btn btn-warning" data-toggle="modal" data-target="#formats">
                                   إضافة شكل كلمة جديد
                               </button>
                               <button class="btn btn-success" data-toggle="modal" data-target="#idioms">
                                   إضافة مصطلح جديد
                               </button>
                           </div>--}}{{--
                     </div>--}}

                </div><!--/tab-content-->
            </div><!--/col-9-->


        </div><!--/row-->

        @include('followers',['username'=>$user->username])
        @include('following',['username'=>$user->username])
    </section>



@endsection
@section('extraJS')

    <script>
        $(document).ready(function () {
            console.log("ready!");
        });
    </script>
    {{-- <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"
             type="text/javascript"></script>
     <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"
             type="text/javascript"></script>

     <script src="{{ themeUrl('backend/assets/pages/scripts/components-editors.min.js') }}"
             type="text/javascript"></script>--}}
@endsection