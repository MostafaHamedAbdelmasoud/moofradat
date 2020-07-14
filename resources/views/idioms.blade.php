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
                <h3 style="font-size:36px;"> المصطلحات التعبيرية
                    <div class="pull-right">
                        <form action="{{ url('/idioms/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>المصطلح</th>
                    <th>الترجمة</th>
                    <th>الشرح</th>
                    <th>مثال</th>
                    {{--<th>بواسطة</th>--}}
                </tr>

                @if($idioms)
                    @foreach($idioms as $idiom)
                        <tr>
                            <td><span>{{ $idiom->title }}<span></td>
                            <td>
                                {{ $idiom->translation }}</td>
                            <td>
                                {!! $idiom->explain !!}
                            </td>
                            <td dir="ltr">
                                {!! $idiom->example !!}

                                <div class="text-right">
                                    @php
                                        if ($idiom->added_by != null)
                                            $user= \App\User::where('id', $idiom->added_by)->first();
                                    @endphp
                                    <strong>
                                        @if($idiom->added_by != null)
                                            <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                        @else
                                            <a href="{{ url('/moofradat') }}">مفردات</a>
                                        @endif
                                    </strong>
                                </div>
                            </td>
                            {{--<td class="text-center">
                                @php
                                    if ($idiom->added_by != null)
                                        $user= \App\User::where('id', $idiom->added_by)->first();
                                @endphp
                                <strong>
                                    @if($idiom->added_by != null)
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
            @if($idioms)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $idioms->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>


@endsection
