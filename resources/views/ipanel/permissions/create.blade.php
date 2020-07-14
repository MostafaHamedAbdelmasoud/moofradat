<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/10/2017
 * Time: 1:17 PM
 */ ?>

<div id="createPermissions" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">Basic Validation</span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN FORM-->
                        <form class="form-horizontal" id="form_sample_1">
                            <div class="form-body">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    هناك بعض الاخطاء. رجاءاً افحص كل الحقول
                                </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button>
                                    Your form validation is successful!
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label class="col-md-3 control-label" for="form_control_1">Name
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="" name="name">
                                            <div class="form-control-focus"></div>
                                            <span class="help-block">أدخل اسم الصلاحية</span>
                                            <div class="form-control-focus"></div>
                                            <i class="fa fa-bell-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">إغلاق</button>
                            <button type="submit" id="add_data" class="btn green btn-outline">حفظ</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>
@section('jsplugins')
    <script src="{{ asset('public/back/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/back/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
            type="text/javascript"></script>
@endsection
@section('jspage')
    <script src="{{ asset('public/back/assets/pages/scripts/form-validation-md.min.js') }}"
            type="text/javascript"></script>
@endsection
