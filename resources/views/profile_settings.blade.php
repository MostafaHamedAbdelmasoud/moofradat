@extends('layouts.other')
@section('content')


    <!-- contact section  -->
    <section class="contact">
        <div class="container">
            <div class="page-header">
                <h3>{{ $title }}</h3>
            </div>


            <div class="row">
                <div class="col-sm-3"><!--left col-->


                    <div class="text-center">
                        <a href="#" onclick="document.getElementById('update_photo').click()">
                            <img src="{{ asset('public/uploads/avatar/'.Auth::user()->avatar) }}"
                                 class="avatar img-circle img-thumbnail" alt="avatar">
                        </a>

                        <form id="update_photo_form" action="{{url('/user/profile/settings/update_avatar')}}"
                              method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input id="update_photo" type="file" name="avatar" style="display: none">
                            </div>
                        </form>

                        <h6>لرفع صورة اخرى إضغط على الصورة الحالية</h6>
                        {{--<input type="file" class="text-center center-block file-upload" name="avatar">--}}
                    </div>
                    <hr>
                    <br>

                    <div>

                        <h3>{{ Auth::user()->name }}</h3>
                        <a href="{{ url('user/profile/'.Auth::user()->username) }}">
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
                        {{--<br><br>
                        <ul class="list-group">
                            <li class="list-group-item text-right"><span
                                        class="pull-left"><strong>متابعون</strong></span> {{ Auth::user()->followers->count() }}
                            </li>
                            <li class="list-group-item text-right"><span
                                        class="pull-left"><strong>متابَعون</strong></span> {{ Auth::user()->followings->count() }}
                            </li>
                        </ul>--}}

                    </div>

                </div><!--/col-3-->


                <div class="col-sm-9">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">تغيير البيانات الشخصية</a></li>
                        <li><a data-toggle="tab" href="#password">تغيير كلمة المرور</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">

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

                            <hr>
                            <form class="form" action="{{ url('user/profile/settings/update_info') }}" method="post">
                                @csrf
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="name"><h4>الإسم بالكامل</h4></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="الإسم بالكامل" title="أدخل الإسم بالكامل"
                                               value="{{ Auth::user()->name }}">
                                    </div>

                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="username"><h4>إسم المستخدم</h4></label>
                                        <input type="text" class="form-control" name="username" id="username"
                                               placeholder="إسم المستخدم" title="أدخل إسم المستخدم"
                                               readonly="readonly"
                                               value="{{ Auth::user()->username }}">
                                    </div>

                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="email"><h4>البريد الإلكتروني</h4></label>
                                        <input type="text" class="form-control" name="email" id="email"
                                               placeholder="البريد الإلكتروني" title="أدخل البريد الإلكتروني"
                                               value="{{ Auth::user()->email }}">
                                    </div>

                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="location"><h4>العنوان</h4></label>
                                        <input type="text" class="form-control" name="location" id="location"
                                               placeholder="العنوان" title="أدخل العنوان"
                                               value="{{ Auth::user()->location }}">
                                    </div>

                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label><h4>نبذة مختصرة</h4></label>
                                        <textarea name="bio" cols="30" rows="5"
                                                  class="form-control">{{ Auth::user()->bio }}</textarea>
                                    </div>

                                    <div class="col-xs-6">
                                        <label for="website"><h4>الموقع الإلكتروني</h4></label>
                                        <input type="url" class="form-control" name="website" id="website"
                                               placeholder="الموقع الإلكتروني" title="أدخل الموقع الإلكتروني"
                                               value="{{ Auth::user()->website }}">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button class="btn btn-lg btn-success" type="submit"><i
                                                    class="glyphicon glyphicon-ok-sign"></i> تحديث المعلومات
                                        </button>
                                    </div>
                                </div>

                            </form>
                            <hr>

                        </div><!--/tab-pane-->
                        <div class="tab-pane" id="password">

                            <hr>
                            <form class="form" action="{{ url('user/profile/settings/update_password') }}"
                                  method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <div class="col-xs-6">
                                                <label for="old_password"><h4>كلمة المرور الحالية</h4></label>
                                                <input type="password" class="form-control" name="old_password"
                                                       id="old_password"
                                                       placeholder="******">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="password"><h4>كلمة المرور الجديدة</h4></label>
                                        <input type="password" class="form-control" name="password"
                                               id="password"
                                               placeholder="******">
                                    </div>

                                </div>
                                <div class="form-group">

                                    <div class="col-xs-6">
                                        <label for="password_confirmation"><h4>تأكيد كلمة المرور الجديدة</h4></label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                               id="password_confirmation"
                                               placeholder="******">
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button class="btn btn-lg btn-success" type="submit"><i
                                                    class="glyphicon glyphicon-ok-sign"></i> تحديث كلمة المرور
                                        </button>
                                    </div>
                                </div>

                            </form>
                            <hr>

                        </div><!--/tab-pane-->
                    </div><!--/tab-pane-->
                </div><!--/tab-content-->

            </div><!--/col-9-->
        </div><!--/row-->

        </div>
    </section>


@endsection
@section('extraJS')
    {{--<script>
        $(document).ready(function () {


            var readURL = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.avatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-upload").on('change', function () {
                readURL(this);
            });
        });
    </script>--}}

    <script type="text/javascript">

        $(document).on('change', '#update_photo', function (a) {
            var iSize = ($('#update_photo')[0].files[0].size / 1024);
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];

            if (iSize / 1024 > 5 || $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert('يجب أن يكون حجم الملف الذي تم تحميله بحجم لا يزيد عن 5 ميغابايت.');
                $(this).val("");
            } else {
                $('#update_photo_form').submit();
            }
        });

    </script>


@endsection