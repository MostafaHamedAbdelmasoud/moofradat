<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>

@extends('layouts.other')

@section('content')
    <!-- contact section  -->
    <section class="section" style="background-color:white;">
        <div class="container">
            <div class="page-header">
                <h3 style="font-size:36px;">{{ $title }}
                    <div class="pull-right">
                        <form action="{{ url('/formats/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>إسم</th>
                    <th>فعل</th>
                    <th>صفة</th>
                    <th>حال</th>
                    {{--<th>بواسطة</th>--}}
                </tr>

                @if($formats)
                    @foreach($formats as $format)
                        <tr>
                            <td class="text-center" dir="ltr"><span>{{ $format->noun }}</span></td>
                            <td class="text-center" dir="ltr"><span>{{ $format->verb }}</span></td>
                            <td class="text-center" dir="ltr"><span>{{ $format->adjective }}</span></td>
                            <td class="text-center" dir="ltr">
                                <span>{{ $format->adverb }}</span>
                                <div class="text-right">
                                    @php
                                        if ($format->added_by != null)
                                            $user= \App\User::where('id', $format->added_by)->first();
                                    @endphp
                                    <strong>
                                        @if($format->added_by != null)
                                            <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                        @else
                                            <a href="{{ url('/moofradat') }}">مفردات</a>
                                        @endif
                                    </strong>
                                </div>
                            </td>
                            {{-- <td class="text-center">
                                 @php
                                     if ($format->added_by != null)
                                         $user= \App\User::where('id', $format->added_by)->first();
                                 @endphp
                                 <strong>
                                     @if($format->added_by != null)
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
            @if($formats)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $formats->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>


@endsection
