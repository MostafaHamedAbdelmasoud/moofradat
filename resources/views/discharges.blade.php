<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>
@extends('layouts.other')

@section('content')
    <section class="section" style="background-color:white;">
        <div class="container">
            <div class="page-header">
                <h3 style="font-size:36px;">التصريفات
                    <div class="pull-right">
                        <form action="{{ url('/discharges/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>التصريف الاول</th>
                    <th>التصريف الثاني</th>
                    <th>التصريف الثالث</th>
                    {{--<th>بواسطة</th>--}}
                </tr>

                @if($discharges)
                    @foreach($discharges as $discharge)
                        <tr>
                            <td><strong>{{ $discharge->en_past }} - {{ $discharge->ar_past }}</strong></td>
                            <td><strong>{{ $discharge->en_present }} - {{ $discharge->ar_present }}</strong></td>
                            <td>
                                <strong>{{ $discharge->en_future }}</strong>
                                <div class="text-right">
                                    @php
                                        if ($discharge->added_by != null)
                                            $user= \App\User::where('id', $discharge->added_by)->first();
                                    @endphp
                                    <strong>
                                        @if($discharge->added_by != null)
                                            <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                        @else
                                            <a href="{{ url('/moofradat') }}">مفردات</a>
                                        @endif
                                    </strong>
                                </div>
                            </td>
                            {{--<td class="text-center">
                                @php
                                    if ($discharge->added_by != null)
                                        $user= \App\User::where('id', $discharge->added_by)->first();
                                @endphp
                                <strong>
                                    @if($discharge->added_by != null)
                                        <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                    @else
                                        -
                                    @endif
                                </strong>
                            </td>--}}
                        </tr>
                    @endforeach
                @endif

            </table>
            @if($discharges)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $discharges->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
