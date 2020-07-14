<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/24/2018
 * Time: 7:35 PM
 */ ?>
@extends('profile.show')
@section('contenttt')
    @if($words_2->count() > 0 || $discharges_2->count() > 0 || $shortcuts_2->count() > 0 || $slang_2->count() > 0 || $terms_2->count() > 0 || $formats_2->count() > 0 || $idioms_2->count() > 0)
        @foreach($words_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>

            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>

        @endforeach

        @foreach($discharges_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>

            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>

        @endforeach

        @foreach($shortcuts_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>
            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>

        @endforeach

        @foreach($slang_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>

            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        @foreach($terms_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>

            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        @foreach($formats_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>

            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        @foreach($idioms_2 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle " width="50" height="50">
                        </figure>
                    </div>
                    <div class="col-sm-6 col-md-10">
                                        <span class="label label-default pull-right">
                                            <i class="fa fa-clock-o"></i>
                                            {{ myDate($w->updated_at) }}
                                        </span>
                        <h4>{{ $user->name }}</h4>
                        <p>
                            <a href="{{ url('/'.$user->username) }}">
                                                    <span dir="ltr"
                                                          style="color: #ACACAC;">{{ '@'.$user->username }}</span>
                            </a>
                        </p>
                        <p>
                            تم رفض الكلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#myModal_{{$w->id}}" class="btn btn-default btn-sm pull-right">أسباب الرفض</a>
                        </section>
                    </div>
                </div>
            </article>

            <!-- Modal -->
            <div id="myModal_{{$w->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">سبب رفض : {{ $w->word }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ $w->note }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    @endif
@endsection
