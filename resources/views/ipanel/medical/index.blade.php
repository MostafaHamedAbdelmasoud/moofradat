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
        @if(Auth::user()->roles[0]->id != 3)
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
            <span class="caption-subject bold uppercase"> قائمة  الانتظار</span>
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
                            <th> الكلمة</th>
                            <th> الترجمة</th>
                            <th> الامثلة</th>
                            <th> الحالة</th>
                            <th> بواسطة</th>
                            <th> الاوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pending as $term)
                            <tr class="odd gradeX">

                                <td><strong>{{ $term->title }}</strong></td>
                                <td> {{ $term->translation }}</td>
                                <td dir="ltr"> {!! (count_chars($term->example) > 70 ) ? substr($term->example, 0,70).' ...' : $term->example !!} </td>


                                <td width="10%">
                                    @if($term->status == 0)
                                        <span class="label label-default">قيد الإنتظار</span>

                                    @elseif($term->status == 1)
                                        <span class="label label-primary">مقبولة</span>

                                    @else
                                        <span class="label label-danger">مرفوضة</span>

                                    @endif
                                </td>

                                <td width="10%">
                                    @php
                                        if ($term->added_by != null)
                                            $user= \App\User::where('id', $term->added_by)->first();
                                    @endphp
                                    <strong>{{ ($user) ? $user->username : '-' }}</strong>
                                </td>

                                <td class="text-center" width="10%">

                                    @if(Auth::user()->roles[0]->id != 3)
                                        
<a href="{{ url('ipanel/medical/status/pending',$term->id) }}" class="btn btn-icon-only blue">
        <i class="fa fa-check"></i>
    </a>
    <button class="btn btn-icon-only red " type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"  data-whatever="{{$term->id}}"><i class="fa fa-remove"></i></button>

                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
                        <span class="caption-subject bold uppercase"> قائمة المصطلحات</span>
                    </div>
                    <div class="actions">
                        <form action="{{ url('/ipanel/medical/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="بحث..." name="q">
                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('medical.create')) }}" class="btn sbold green"> إضافة جديد
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
                            <th> الكلمة</th>
                            <th> الترجمة</th>
                            <th> الامثلة</th>
                            <th> الحالة</th>
                            <th> بواسطة</th>
                            <th> الاوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($terms as $term)
                            <tr class="odd gradeX">

                                <td><strong>{{ $term->title }}</strong></td>
                                <td> {{ $term->translation }}</td>
                                <td dir="ltr"> {!! (count_chars($term->example) > 70 ) ? substr($term->example, 0,70).' ...' : $term->example !!} </td>


                                <td width="10%">
                                    @if($term->status == 0)
                                        <span class="label label-default">قيد الإنتظار</span>

                                    @elseif($term->status == 1)
                                        <span class="label label-primary">مقبولة</span>

                                    @else
                                        <span class="label label-danger">مرفوضة</span>

                                    @endif
                                </td>

                                <td width="10%">
                                    @php
                                        if ($term->added_by != null)
                                            $user= \App\User::where('id', $term->added_by)->first();
                                    @endphp
                                    <strong>{{ ($user) ? $user->username : '-' }}</strong>
                                </td>

                                <td class="text-center" width="10%">

                                    @if(Auth::user()->roles[0]->id != 3)
                                        <a href="{{ url('ipanel/medical/'.$term->id) }}" class="btn btn-icon-only blue">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-icon-only red delete-term"
                                                data-id="{{ $term->id }}">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-md-12">
                            @if($terms)
                                {{ $terms->links() }}
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
              <form  method="Post" action="{{ route('medical.status') }}">

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
            console.log('Document is Ready..')
            $('.delete-term').click(function () {
                //var id = $(this).closest(".delete-permission").attr("data-id");
                //alert('clicked..' + id)
                var id = $(this).closest(".delete-term").attr("data-id");
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
                        $deleteItem = '{{ url('ipanel/medical/destroy') }}' + '/' + id;
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
