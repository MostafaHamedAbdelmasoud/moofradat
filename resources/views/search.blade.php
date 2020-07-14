<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>


@extends('layouts.other')

@section('content')

    <section class="section">
        <div class="container">
            <div class="page-header">
                <h2>{{ $title }} </h2>
            </div>
        </div>
    </section>


    @if(count($words) > 0)
        <!-- Words section  -->
        <section class="section">
            <div class="container">
                <div class="page-header">
                    <h3>الكلمات </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>الكلمة</th>
                        <th>الترجمة</th>
                        <th>التعريف</th>
                        <th>امثلة</th>
                    </tr>

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
                                                -
                                            @endif
                                        </strong>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>
    @endif


    @if(count($discharges) > 0)
        <!-- Discharges section  -->
        <section class="section">
            <div class="container">
                <div class="page-header">
                    <h3>تصريفات </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>التصريف الاول</th>
                        <th>التصريف الثاني</th>
                        <th>التصريف الثالث</th>
                    </tr>

                    @foreach($discharges as $discharge)
                        <tr>
                            <td><strong>{{ $discharge->en_past }} - {{ $discharge->ar_past }}</strong></td>
                            <td><strong>{{ $discharge->en_present }} - {{ $discharge->ar_present }}</strong></td>
                            <td><strong>{{ $discharge->en_future }}</strong>
                                <div class="text-right">
                                    <p>
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
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>
    @endif


    @if(count($shortcuts) > 0)
        <!-- Shortcuts section  -->
        <section class="shortcut">
            <div class="container">
                <div class="page-header">
                    <h3>الاختصارات </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>الاختصار</th>
                        <th>التعريف</th>
                        <th>الترجمة</th>
                    </tr>

                    @foreach($shortcuts as $shortcut)
                        <tr>
                            <td><span>{{ $shortcut->shortcut }} </span></td>
                            <td>{{ $shortcut->mean }}</td>
                            <td>{{ $shortcut->translation }}

                                <div class="text-right">
                                    <p>
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
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </table>

            </div>
        </section>
    @endif



    @if(count($slang) > 0)
        <!-- Slang section  -->
        <section class="shortcut">
            <div class="container">
                <div class="page-header">
                    <h3>الكلمات العامية </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>الكلمة/الجملة</th>
                        <th>الترجمة</th>
                    </tr>


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
                                                -
                                            @endif
                                        </strong>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>
    @endif


    @if(count($terms) > 0)
        <!-- Medical section  -->
        <section class="section">
            <div class="container">
                <div class="page-header">
                    <h3>المصطلحات الطبية </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>الكلمة</th>
                        <th>الترجمة</th>
                        <th>امثلة</th>
                    </tr>

                    @foreach($terms as $term)
                        <tr>
                            <td><span>{{ $term->title }}<span></td>
                            <td>
                                {{ $term->translation }}
                            </td>
                            <td dir="ltr">
                                {!! $term->example !!}

                                <div class="text-right">
                                    <p>
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
                                    </p>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>
    @endif



    @if(count($formats) > 0)
        <!-- Slang section  -->
        <section class="shortcut">
            <div class="container">
                <div class="page-header">
                    <h3>شكل الكلمة </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>إسم</th>
                        <th>فعل</th>
                        <th>صفة</th>
                        <th>حال</th>
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
                                        <p>
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
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif


                </table>
            </div>
        </section>
    @endif

    @if(count($idioms) > 0)
        <!-- contact section  -->
        <section class="section">
            <div class="container">
                <div class="page-header">
                    <h3>المصطلحات
                    </h3>
                </div>
                <table class="table table-responsive">

                    <tr>
                        <th>المصطلح</th>
                        <th>الترجمة</th>
                        <th>الشرح</th>
                        <th>مثال</th>
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
                                        <p>
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
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif


                </table>
            </div>
        </section>
    @endif


@endsection

