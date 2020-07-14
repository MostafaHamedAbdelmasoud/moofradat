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
                        <form action="{{ url('/medical/search') }}" method="get">
                            <input type="text" class="form-control" placeholder="إبحث ..." name="q">
                        </form>
                    </div>
                </h3>
            </div>
            <table class="table table-responsive">

                <tr>
                    <th>الكلمة</th>
                    <th>الترجمة</th>
                    <th>امثلة</th>
                    {{--<th>بواسطة</th>--}}
                </tr>

                @if($terms)
                    @foreach($terms as $term)
                        <tr>
                            <td><span>{{ $term->title }}<span></td>
                            <td>
                                {{ $term->translation }}</td>

                            <td dir="ltr">
                                {!! $term->example !!}

                                <div class="text-right">
                                    @php
                                        if ($term->added_by != null)
                                            $user= \App\User::where('id', $term->added_by)->first();
                                    @endphp
                                    <strong>
                                        @if($term->added_by != null)
                                            <a href="{{ url('/'.$user->username) }}">{{ $user->name }}</a>
                                        @else
                                            <a href="{{ url('/moofradat') }}">مفردات</a>
                                        @endif
                                    </strong>
                                </div>

                            </td>
                            {{--<td class="text-center">
                                @php
                                    if ($term->added_by != null)
                                        $user= \App\User::where('id', $term->added_by)->first();
                                @endphp
                                <strong>
                                    @if($term->added_by != null)
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
            @if($terms)
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="font-size:28px;">
                            {{ $terms->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>


@endsection
