<?php
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
                @if (Auth::user()->roles[0]->id != 3) 

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> مصطلحات قيد الانتظار </span>
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
                            <th> التصريف الاول</th>
                            <th> التصريف الثاني</th>
                            <th> التصريف الثالث</th>
                            <th> الحالة</th>
                            <th> بواسطة</th>
                            <th> الاوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pending as $discharge)
                            <tr class="odd gradeX">

                                <td><strong>{{ $discharge->en_past }}</strong></td>
                                <td><strong>{{ $discharge->en_present }}</strong></td>
                                <td><strong>{{ $discharge->en_future }}</strong></td>

                                <td width="10%">
                                    @if($discharge->status == 0)
                                        <span class="label label-default">قيد الإنتظار</span>

                                    @elseif($discharge->status == 1)
                                        <span class="label label-primary">مقبولة</span>

                                    @else
                                        <span class="label label-danger">مرفوضة</span>

                                    @endif
                                </td>

                                <td width="10%">
                                    @php
                                        if ($discharge->added_by != null)
                                            $user= \App\User::where('id', $discharge->added_by)->first();
                                    @endphp
                                    <strong>{{ ($user) ? $user->username : '-' }}</strong>
                                </td>


                                <td class="text-center">
                                    @if(Auth::user()->roles[0]->id != 3)
                                        <!--<a href="{{ url('ipanel/discharges/'.$discharge->id) }}"-->
                                        <!--   class="btn btn-icon-only blue">-->
                                        <!--    <i class="fa fa-edit"></i>-->
                                        <!--</a>-->
                                        <!--<button class="btn btn-icon-only red delete-discharge"-->
                                        <!--        data-id="{{ $discharge->id }}">-->
                                        <!--    <i class="fa fa-remove"></i>-->
                                        <!--</button>-->
                                        
                                            <a href="{{ url('ipanel/discharges/status/pending',$discharge->id) }}" class="btn btn-icon-only blue">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <button class="btn btn-icon-only red " type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"  data-whatever="{{$discharge->id}}"><i class="fa fa-remove"></i></button>

    
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
                            @if($discharges)
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
                        <form action="{{ url('/ipanel/discharges/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="بحث..." name="q">
                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('discharges.create')) }}" class="btn sbold green"> إضافة جديد
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
                            <th> التصريف الاول</th>
                            <th> التصريف الثاني</th>
                            <th> التصريف الثالث</th>
                            <th> الحالة</th>
                            <th> بواسطة</th>
                            <th> الاوامر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($discharges as $discharge)
                            <tr class="odd gradeX">

                                <td><strong>{{ $discharge->en_past }}</strong></td>
                                <td><strong>{{ $discharge->en_present }}</strong></td>
                                <td><strong>{{ $discharge->en_future }}</strong></td>

                                <td width="10%">
                                    @if($discharge->status == 0)
                                        <span class="label label-default">قيد الإنتظار</span>

                                    @elseif($discharge->status == 1)
                                        <span class="label label-primary">مقبولة</span>

                                    @else
                                        <span class="label label-danger">مرفوضة</span>

                                    @endif
                                </td>

                                <td width="10%">
                                    @php
                                        if ($discharge->added_by != null)
                                            $user= \App\User::where('id', $discharge->added_by)->first();
                                    @endphp
                                    <strong>{{ ($user) ? $user->username : '-' }}</strong>
                                </td>


                                <td class="text-center">
                                    @if(Auth::user()->roles[0]->id != 3)
                                        <a href="{{ url('ipanel/discharges/'.$discharge->id) }}"
                                           class="btn btn-icon-only blue">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-icon-only red delete-discharge"
                                                data-id="{{ $discharge->id }}">
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
                            @if($discharges)
                                {{ $discharges->links() }}
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
        <h5 class="modal-title" id="exampleModalLabel">سبب رفض  المصطلح</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
              <form  method="Post" action="{{ route('discharges.status') }}">

      <div class="modal-body">
                        {{ csrf_field() }}
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">كود :</label>
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
            $('.delete-discharge').click(function () {
                //var id = $(this).closest(".delete-permission").attr("data-id");
                //alert('clicked..' + id)
                var id = $(this).closest(".delete-discharge").attr("data-id");
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
                        $deleteItem = '{{ url('ipanel/discharges/destroy') }}' + '/' + id;
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
