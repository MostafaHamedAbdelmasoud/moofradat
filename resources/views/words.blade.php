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
                <h3 style="font-size:36px;">الكلمات
                    {{--<div class="pull-right">
                        <form action="{{ url('/words/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>--}}
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>الكلمة</th>
                    <th>الترجمة</th>
                    <th>التعريف</th>
                    <th>امثلة</th>
                    {{--<th>بواسطة</th>--}}
                </tr>

                @if($words)
                    @foreach($words as $word)
                        <tr>
                            <td><span>{{ $word->title }}<span></td>
                            <td>
                                {{ $word->translation }}</td>
                            <td>
                                {!! $word->definition !!}
                            </td>
                            <td dir="ltr">
                                {!! $word->examples !!}

                                <div class="text-right">
                                    <p>
                                        @php
                                            if ($word->added_by != null)
                                                $user= \App\User::where('id', $word->added_by)->first();
                                        @endphp
                                        <strong>
                                            @if($word->added_by != null)
                                                <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                            @else
                                                <a href="{{ url('/moofradat') }}">مفردات</a>
                                            @endif
                                        </strong>
                                    </p>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @endif


            </table>
            @if($words)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $words->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>


@endsection
