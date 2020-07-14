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
                <h3 style="font-size:36px;">{{ $title }}
                    <div class="pull-right">
                        <form action="{{ url('/slang/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>الكلمة/الجملة</th>
                    <th>الترجمة</th>
                    {{--<th>بواسطة</th>--}}
                </tr>


                @if($slang)
                    @foreach($slang as $item)
                        <tr>
                            <td><span>{{ $item->sentence }} </span></td>
                            <td>{!! $item->translation !!}

                                <div class="text-right">
                                    <p>
                                        @php
                                            if ($item->added_by != null)
                                                $user= \App\User::where('id', $item->added_by)->first();
                                        @endphp
                                        <strong>
                                            @if($item->added_by != null)
                                                <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                            @else
                                                <a href="{{ url('/moofradat') }}">مفردات</a>
                                            @endif
                                        </strong>
                                    </p>
                                </div>
                            </td>

                            {{--<td class="text-center">
                                @php
                                    if ($item->added_by != null)
                                        $user= \App\User::where('id', $item->added_by)->first();
                                @endphp
                                <strong>
                                    @if($item->added_by != null)
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
            @if($slang)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $slang->links() }}
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>


@endsection
