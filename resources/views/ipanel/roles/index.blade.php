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
                        <i class="icon-shield font-dark"></i>
                        <span class="caption-subject bold uppercase"> قائمة الادوار</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button class="btn sbold green"
                                            data-toggle="modal" data-target="#roleModal"> إضافة جديد
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- id="sample_1" -->
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                        <tr>
                            <th> الدور</th>
                            <th>الصلاحيات</th>
                            <th> الأوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($roles)
                            @foreach($roles as $role)
                                <tr class="odd gradeX">
                                    <td><b>{{ $role->name }}</b></td>


                                    <td>{{ substr(str_replace(['[',']','"'], '', $role->permissions()->pluck('name')),0,100) }}
                                        ....
                                    </td>


                                    <td class="text-center">
                                        <a href="{{ url('ipanel/roles',$role->id) }}" class="btn btn-icon-only blue">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <button class="btn btn-icon-only red delete-role" data-id="{{ $role->id }}">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 left">
                            @if($roles)
                                {{ $roles->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>


    <!-- Create Modal -->
    <div id="roleModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">إضافة دور جديدة</h4>
                </div>
                <form method="post" action="{{ url(route('roles.store')) }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label>إسم الدور</label>
                            <div class="input-group">
                                   <span class="input-group-addon input-circle-left">
                                          <i class="fa fa-globe"></i>
                                   </span>
                                <input type="text" class="form-control input-circle-right"
                                       placeholder="أدخل إسم الدور" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>إختر الصلاحيات التي تريد إضافتها بضغط على CTRL+تحديد الصلاحيات المراد حفظها</label>
                            <select multiple class="form-control" name="permissions[]">
                                @if($permissions)
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->id }}" >{{ $permission->name }}</option>
                                    @endforeach
                                @else
                                    <option>لا توجد صلاحيات متاحة</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">حفظ</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- End Create Modal -->



@endsection
@section('jsCode')
    <script type="text/javascript">
        $(document).ready(function () {
            console.log('Document is Ready..')
            $('.delete-role').click(function () {
                //var id = $(this).closest(".delete-permission").attr("data-id");
                //alert('clicked..' + id)
                var id = $(this).closest(".delete-role").attr("data-id");
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
                        $deleteItem = '{{ url('ipanel/roles/destroy') }}' + '/' + id;
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