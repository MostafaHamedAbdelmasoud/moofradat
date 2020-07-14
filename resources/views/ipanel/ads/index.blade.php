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
                        <span class="caption-subject bold uppercase"> قائمة الاعلانات  </span>
                    </div>
                    <div class="actions">
                        <form action="{{ url('/ipanel/ads/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="بحث..." name="q">
                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('ads.create')) }}" class="btn sbold green"> إضافة
                                        جديد
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
                            <th> الاعلان</th>
                            <th> الفئة</th>
                            <th> الاوامر</th>
                        </tr>

                        </thead>
                        <tbody>
                        @if($ads)
                            @foreach($ads as $ad)
                                <tr class="odd gradeX">

                                    <td><strong><?php
                                            $string = (strlen(strip_tags($ad->content)) > 50) ? substr(strip_tags($ad->content),0,49).'...' : $ad->content;
                                            echo html_entity_decode($string);
                                            ?></strong></td>
                                    <td><strong>{{ $ad->type->title }}</strong></td>

                                    <td class="text-center">
                                        <a href="{{ url('ipanel/ads/'.$ad->id) }}"
                                           class="btn btn-icon-only blue">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-icon-only red delete-ads"
                                                data-id="{{ $ad->id }}">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-md-12">
                            @if($ads)
                                {{ $ads->links() }}
                            @endif
                        </div>
                    </div>


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
            $('.delete-ads').click(function () {
                //var id = $(this).closest(".delete-permission").attr("data-id");
                //alert('clicked..' + id)
                var id = $(this).closest(".delete-ads").attr("data-id");
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
                        $deleteItem = '{{ url('ipanel/ads/destroy') }}' + '/' + id;
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
