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
@section('content')

    @if(session('message'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-block {{ session('type') }} fade in">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <h4 class="alert-heading">{{ session('message') }}</h4>
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> قائمة المسنخدمين</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('users.create')) }}" class="btn sbold green"> إضافة جديد
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- id="sample_1" -->
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                        <tr>
                            <th> إسم المستخدم</th>
                            <th> البريد الالكتروني</th>
                            <th> الدور</th>

                            <th> الحالة</th>
                            <th> توثيق الحساب</th>


                            <th> تاريخ التسجيل</th>
                            <th> الأوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users)
                            @foreach($users as $user)
                                <tr class="odd gradeX">
                                    <td> {{ $user->admin_name=='' ?$user->username: $user->admin_name}}</td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}"> {{ $user->email }} </a>
                                    </td>
                                    <td>
                                        <span class="label label-danger">{{ $user->roles()->pluck('name')->implode(' ') }}</span>
                                    </td>

                                    <td>
                                        @if($user->verifed == 0)
                                            <span class="label label-default">غير فعال</span>
                                        @else
                                            <span class="label label-primary">فعال</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->blue_mark == 0)
                                            <span class="label label-default">غير موثق</span>
                                        @else
                                            <span class="label label-success">موثق</span>
                                        @endif
                                    </td>

                                    <td class="center">{{ date('jS F Y',strtotime($user->created_at)) }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('ipanel/users',$user->id )}}"
                                           class="btn btn-icon-only blue">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        @if($user->verifed == 0)
                                            <a href="{{ url('ipanel/users/resend',$user->id )}}"
                                               class="btn btn-icon-only green-dark">
                                                <i class="icon-paper-plane"></i>
                                            </a>
                                        @else
                                            <a href="#"
                                               class="btn btn-icon-only green-dark" disabled>
                                                <i class="icon-paper-plane"></i>
                                            </a>
                                        @endif


                                        <button class="btn btn-icon-only red delete-user" data-id="{{ $user->id }}">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if($users)
                        <div class="row">
                            <div class="col-md-12">
                                {{ $users->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->


        </div>
    </div>
@endsection
@section('jsCode')
    <script type="text/javascript">
        $(document).ready(function () {
            console.log('Document is Ready..')
            $('.delete-user').click(function () {
                //var id = $(this).closest(".delete-permission").attr("data-id");
                //alert('clicked..' + id)
                var id = $(this).closest(".delete-user").attr("data-id");
                swal({
                        title: "حذف العنصر!",
                        text: "هل تريد حذف هذا العنصر",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "نعم, قم بذلك.",
                        cancelButtonText: "لا, اريد التراجع!",
                        closeOnConfirm: false
                    },
                    function () {
                        swal("شكراً لك!", "سيتم حذف العنصر خلال بضع ثواني", "success");
                        $
                        $deleteItem = '{{ url('ipanel/users/destroy') }}' + '/' + id;
                        setTimeout(function () {
                            // Do something after 1 second
                            window.location.href = $deleteItem;
                            //alert($deleteItem)
                        }, 2000);
                    });

            });
        });
    </script>
@endsection