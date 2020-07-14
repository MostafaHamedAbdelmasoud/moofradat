<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 7/10/2017
 * Time: 1:15 PM
 */
?>
@extends('layouts.ipanel')


@section('extraCss')
<style>
        .selectManyElements{
            display:none!important;
        }


</style>
@endsection

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
        @if(Auth::user()->roles[0]->id != 3)

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> قيد الانتظار</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- id="sample_1" -->
                    <table class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                        <tr>
                            <th> الجملة</th>
                            <th>الترجمة</th>
                            <th> الحالة</th>
                            <th> بواسطة</th>
                            <th> الاوامر</th>
                            <th> تحديد عناصر للرفض</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($pending)
                    <form action="{{ url('/ipanel/deleteSelected') }}"method="POST" >
                        {{ csrf_field() }}
                            @foreach($pending as $item)
                                <tr class="odd gradeX">

                                    <td><strong>{{ $item->sentence }}</strong></td>
                                    <td><strong><?= html_entity_decode($item->translation)?></strong></td>

                                    <td width="10%">
                                        @if($item->status == 0)
                                            <span class="label label-default">قيد الإنتظار</span>

                                        @elseif($item->status == 1)
                                            <span class="label label-primary">مقبولة</span>

                                        @else
                                            <span class="label label-danger">مرفوضة</span>

                                        @endif
                                    </td>

                                    <td width="10%">
                                        @php
                                            if ($item->added_by != null)
                                                $user= \App\User::where('id', $item->added_by)->first();
                                        @endphp
                                        <strong>{{ ($user) ? $user->username : '-' }}</strong>
                                    </td>

                                    <td class="text-center">
                                        @if(Auth::user()->roles[0]->id != 3)
    <a href="{{ url('ipanel/slang/status/pending',$item->id) }}" class="btn btn-icon-only blue">
        <i class="fa fa-check"></i>
    </a>
    <button class="btn btn-icon-only red " type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"  data-whatever="{{$item->id}}"><i class="fa fa-remove"></i></button>
    
        <!--<div class="form-control">-->
        <!--</div>-->
        <!--<div class="form-control">-->
            <!--<input type="checkbox" name="deletes[]" value="{{$item->id}}" >-->
            <!--<label for="exampleInputEmail1">سبب الرفض</label>-->
            <!--<label>سبب الرفض</label>-->
            <!--<input id="exampleInputEmail1" type="text" name="refuse[]"  >-->
        <!--</div>-->

                                        @else
                                            -
                                        @endif
                                    </td>
                                    
                                   
                                    <td class="text-center">
                                        @if(Auth::user()->roles[0]->id != 3)
    
        <!--<div class="form-control">-->
        <!--</div>-->
        <!--<div class="form-control">-->
            <input type="checkbox" name="deletes[]" value="{{$item->id}}" >
            <label for="exampleInputEmail1">سبب الرفض</label>
            <!--<label>سبب الرفض</label>-->
            <input id="exampleInputEmail1" type="text" name="refuse[]"  >
        <!--</div>-->

                                        @else
                                            -
                                        @endif
                                    </td>
                                    
                                    
                                    
                                </tr>
                            @endforeach
        <button type="submit" class="btn btn-danger">إزالة المُحدد</button>
    </form>
                        @endif
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-md-12">
                            @if($pending)
                                {{ $pending->links() }}
                            @endif
                        </div>
                    </div>


                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
        @endif
        
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> قائمة الجمل العامة</span>
                    </div>
                    <div class="actions">
                        <form action="{{ url('/ipanel/slang/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="بحث..." name="q">
                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('slang.create')) }}" class="btn sbold green"> إضافة جديد
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
                            <th> تحديد</th>
                            <th> الجملة</th>
                            <th>الترجمة</th>
                            <th> الحالة</th>
                            <th> بواسطة</th>
                            <th> الاوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($slang)
                                <tr class="odd gradeX">
                      <form action="{{ url('/ipanel/deleteSelected') }}"method="POST" >
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">إزالة المُحدد</button>
                            @foreach($slang as $item)
                                <td>
                                     <input type="checkbox" name="deletes[]" value="{{$item->id}}" >
           
                                </td>
                    </form>
                                    <td><strong>{{ $item->sentence }}</strong></td>
                                    <td><strong><?= html_entity_decode($item->translation)?></strong></td>

                                    <td width="10%">
                                        @if($item->status == 0)
                                            <span class="label label-default">قيد الإنتظار</span>

                                        @elseif($item->status == 1)
                                            <span class="label label-primary">مقبولة</span>

                                        @else
                                            <span class="label label-danger">مرفوضة</span>

                                        @endif
                                    </td>

                                    <td width="10%">
                                        @php
                                            if ($item->added_by != null)
                                                $user= \App\User::where('id', $item->added_by)->first();
                                        @endphp
                                        <strong>{{ ($user) ? $user->username : '-' }}</strong>
                                    </td>

                                    <td class="text-center">
                                        @if(Auth::user()->roles[0]->id != 3)
                                        <a href="{{ url('ipanel/slang/'.$item->id) }}"
                                           class="btn btn-icon-only blue">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-icon-only red delete-slang"
                                                data-id="{{ $item->id }}">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-md-12">
                            @if($slang)
                                {{ $slang->links() }}
                            @endif
                        </div>
                    </div>


                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">سبب رفض الكلمة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
              <form  method="Post" action="{{ route('slang.status') }}">

      <div class="modal-body">
                        {{ csrf_field() }}
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">كود الكلمة:</label>
            <input type="text" class="form-control" name="id" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">سبب الرفض:</label>
            <textarea class="form-control" name="refuse" id="message-text"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
              </form>

    </div>
  </div>
</div>

@endsection

@section('jsCode')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete-slang').click(function () {
            console.log('Document is Ready..')
                //var id = $(this).closest(".delete-permission").attr("data-id");
                //alert('clicked..' + id)
                var id = $(this).closest(".delete-slang").attr("data-id");
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
                        $deleteItem = '{{ url('ipanel/slang/destroy') }}' + '/' + id;
                        setTimeout(function () {
                            // Do something after 1 second
                            window.location.href = $deleteItem;
                            //alert($deleteItem)
                        }, 2000);
                    });

            });
        });
        
    </script>
        <script>
                    $('#exampleModal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var recipient = button.data('whatever') // Extract info from data-* attributes
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              var modal = $(this)
              modal.find('.modal-title').text('سبب الرفض ' + recipient)
              modal.find('.modal-body #recipient-name').val(recipient)
            })
    </script>
@endsection
