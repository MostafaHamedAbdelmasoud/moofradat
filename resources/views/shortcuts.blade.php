<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>
@extends('layouts.other')

@section('content')

    <!-- shortcut section  -->
    <section class="section" style="background-color:white;">
        <div class="container">
            <div class="page-header">
                <h3 style="font-size:36px;">الاختصارات
                    <div class="pull-right">
                        <form action="{{ url('/shortcuts/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>الاختصار</th>
                    <th>التعريف</th>
                    <th>الترجمة</th>
                    {{--<th>بواسطة</th>--}}
                </tr>

                @if($shortcuts)
                    @foreach($shortcuts as $shortcut)
                        <tr>
                            <td><span>{{ $shortcut->shortcut }} </span></td>
                            <td>{{ $shortcut->mean }}</td>
                            <td>{{ $shortcut->translation }}
                                <div class="text-right">
                                    @php
                                        if ($shortcut->added_by != null)
                                            $user= \App\User::where('id', $shortcut->added_by)->first();
                                    @endphp
                                    <strong>
                                        @if($shortcut->added_by != null)
                                            <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                        @else
                                            <a href="{{ url('/moofradat') }}">مفردات</a>
                                        @endif
                                    </strong>
                                </div>
                            </td>
                            {{--<td class="text-center">
                                @php
                                    if ($shortcut->added_by != null)
                                        $user= \App\User::where('id', $shortcut->added_by)->first();
                                @endphp
                                <strong>
                                    @if($shortcut->added_by != null)
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

            @if($shortcuts)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $shortcuts->links() }}
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </section>


@endsection
