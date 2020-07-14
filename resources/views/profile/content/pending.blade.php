<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/24/2018
 * Time: 7:35 PM
 */ ?>
@extends('profile.show')
@section('contenttt')
    @if($words_0->count() > 0 || $discharges_0->count() > 0 || $shortcuts_0->count() > 0 || $slang_0->count() > 0 || $terms_0->count() > 0 || $formats_0->count() > 0 || $idioms_0->count() > 0)
        @foreach($words_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($discharges_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($shortcuts_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($slang_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($terms_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($formats_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

        @foreach($idioms_0 as $w)
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
                            قيد المراجعة
                            <strong>" {{ $w->word }} "</strong>
                        </p>
                        <section>
                            <a href="#" class="btn btn-default btn-sm pull-right"> > </a>
                        </section>
                    </div>
                </div>
            </article>
        @endforeach

    @endif
@endsection
