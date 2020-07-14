<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/24/2018
 * Time: 7:35 PM
 */ ?>
@extends('profile.edit')
@section('contenttt')
    @if($words_1->count() > 0 || $discharges_1->count() > 0 || $shortcuts_1->count() > 0 || $slang_1->count() > 0 || $terms_1->count() > 0 || $formats_1->count() > 0 || $idioms_1->count() > 0)
        @foreach($words_1 as $w)
            <article>
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <figure>
                            <img src="{{ asset('public/uploads/avatar/'.$user->avatar) }}"
                                 class="img-circle" height="50" width="50">
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($discharges_1 as $w)
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($shortcuts_1 as $w)
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($slang_1 as $w)
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($terms_1 as $w)
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($formats_1 as $w)
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($idioms_1 as $w)
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
                            تمت إضافة كلمة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="{{ url('/search?q='.$w->word) }}" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

    @endif
@endsection
