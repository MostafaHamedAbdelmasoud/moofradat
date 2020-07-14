@extends('layouts.other')

{{--@section('extraCss')
    <link href="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5-rtl.css') }}"
          rel="stylesheet" type="text/css"/>
@endsection--}}
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
                        <img src="{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}"
                             class="avatar img-circle img-thumbnail" alt="avatar">

                        <br><br>
                    </div>
                    <hr>
                    <br>

                    <div>


                        <h3>{{ Auth::user()->name }}</h3>
                        <a href="{{ url('/'.Auth::user()->username) }}">
                            <small dir="ltr">{{ '@'.Auth::user()->username }}</small>
                        </a>
                        <br>
                        <br>
                        <p>{{ Auth::user()->bio }}</p>

                        <br><br>
                        <span>
                            <i class="fa fa-map-marker"></i>
                            {{ (isset(Auth::user()->location)) ? Auth::user()->location : 'لم يتم تحديدها' }}
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
                                        class="pull-left"><strong>متابعون</strong></span> {{ Auth::user()->followers->count() }}
                            </li>
                            <li class="list-group-item text-right"><span
                                        class="pull-left"><strong>متابَعون</strong></span> {{ Auth::user()->followings->count() }}
                            </li>
                        </ul>
                    </div>

                </div><!--/col-3-->

                <div class="col-sm-9">
                    <form role="form" method="post"
                          action="{{ url('/user/editRequest') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{ $req->id }}">
                        <div class="form-body">
                            <div class="form-group">
                                <label>الكلمة/المصطلح</label>
                                <input type="text" class="form-control input-circle-right"
                                       placeholder="أدخل الكلمة" name="title"
                                       value="{{ $req->title }}">
                            </div>

                            <div class="form-group">
                                <label>إختر القسم</label>
                                <select name="type" class="form-control">
                                    <option value="1" {{ ($req->type == 1) ? 'selected="selected"':'' }}>الكلمات
                                    </option>
                                    <option value="2" {{ ($req->type == 2) ? 'selected="selected"':'' }}>التصريفات
                                    </option>
                                    <option value="3" {{ ($req->type == 3) ? 'selected="selected"':'' }}>المصطلحات
                                        الطبية
                                    </option>
                                    <option value="4" {{ ($req->type == 4) ? 'selected="selected"':'' }}>الإختصارات
                                    </option>
                                    <option value="5" {{ ($req->type == 5) ? 'selected="selected"':'' }}>الكلمات
                                        العامة
                                    </option>
                                    <option value="6" {{ ($req->type == 6) ? 'selected="selected"':'' }}>شكل الكلمة
                                    </option>
                                    <option value="7" {{ ($req->type == 7) ? 'selected="selected"':'' }}>المصطلحات
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>الوصف/الشرح</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                            <textarea class="form-control" rows="6"
                                                                      name="description">{{ $req->description }}</textarea>
                                                <small id="emailHelp" class="form-text text-muted">قم بكتابة وصف
                                                    وشرح كامل للكلمة المراد إضافتها مع الأخذ بعين الأعتبار كتابة
                                                    الكلمة وإختيار نوعها
                                                </small>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>الحالة: </label>
                                        @if($req->status == 0)
                                            <span class="label label-default">قيد الإنتظار</span>
                                        @elseif($req->status == 1)
                                            <span class="label label-primary">مقبولة</span>
                                        @else
                                            <span class="label label-danger">مرفوضة</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <br>
                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-primary btn-block">حــــفظ</button>
                        </div>
                    </form>
                </div><!--/tab-content-->
            </div><!--/col-9-->


        </div><!--/row-->
    </section>



@endsection
@section('extraJS')
    {{-- <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"
             type="text/javascript"></script>
     <script src="{{ themeUrl('backend/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"
             type="text/javascript"></script>

     <script src="{{ themeUrl('backend/assets/pages/scripts/components-editors.min.js') }}"
             type="text/javascript"></script>--}}
@endsection