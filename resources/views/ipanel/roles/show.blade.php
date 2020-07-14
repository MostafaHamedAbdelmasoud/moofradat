<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/10/2017
 * Time: 1:17 PM
 */ ?>

@extends('layouts.ipanel')
@section('title', $title)
@section('content')
    @if(session('message'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-block {{ session('type') }} fade in">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <h4 class="alert-heading">{{ session('message') }}</h4>
                    @if (isset($errors) && count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-shield"></i> تعديل الدور: {{ $role->name }}
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" method="post" action="{{ url('ipanel/roles/update',$role->id) }}">
                        {{ csrf_field() }}

                        <div class="form-body">


                            <div class="form-group">
                                <label>إسم الدور</label>
                                <div class="input-group">
                                   <span class="input-group-addon input-circle-left">
                                          <i class="fa fa-globe"></i>
                                   </span>
                                    <input type="text" class="form-control input-circle-right"
                                           placeholder="أدخل إسم الدور" name="name"
                                           value="{{ $role->name }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label> الصلاحيات </label>
                                @if($role->permissions)
                                    <div class="row">
                                        @foreach($role->permissions as $permission)
                                            <div class="col-md-2 margin-bottom-10">
                                                <span class="label label-sm label-success"> {{ $permission->name }} </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    Hihi
                                @endif

                            </div>

                            <div class="form-group">
                                <a data-toggle="modal" data-target="#addPermission">إضافة صلاحية لهذا الدور</a>
                            </div>


                        </div>
                        <div class="form-actions right">
                            <button type="submit" class="btn btn-circle blue">حــــفظ</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>


    <!-- Create Modal -->
    <div id="addPermission" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تعديل الصلاحية</h4>
                </div>
                <form method="post" action="{{ url('ipanel/roles/'.$role->id.'/permissions') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label>إختر الصلاحيات التي تريد إضافتها بضغط على CTRL+تحديد الصلاحيات المراد حفظها</label>
                            <select multiple class="form-control" name="permissions[]">
                                @if($permissions)
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->id }}" @foreach ($role->permissions as $role_permissions) {{ ($role_permissions->id == $permission->id) ? 'selected="selected"': '' }} @endforeach>{{ $permission->name }}</option>
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

