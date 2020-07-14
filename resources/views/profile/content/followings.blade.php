<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/24/2018
 * Time: 8:39 PM
 */ ?>
@extends('profile.show')
@section('extraCss')
    <style>
        .twPc-div {
            background: #fff none repeat scroll 0 0;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            height: 250px;
            max-width: 340px;
        / / orginal twitter width: 290 px;
        }

        .twPc-bg {
            background-image: url("{{ asset('/public/moofradat-cover.png') }}");
            background-position: 0 50%;
            background-size: 100% auto;
            border-bottom: 1px solid #e1e8ed;
            border-radius: 4px 4px 0 0;
            height: 70px;
            width: 100%;
        }

        .twPc-block {
            display: block !important;
        }

        .twPc-button {
            margin: -35px -10px 0;
            text-align: right;
            width: 100%;
        }

        .twPc-avatarLink {
            /*background-color: #fff;
            border-radius: 10px;*/
            display: inline-block !important;
            float: right;
            margin: -30px 5px 0 8px;
            max-width: 100%;
            padding: 1px;
            vertical-align: bottom;
        }

        .twPc-avatarImg {
            /* border: 7px solid #fff;
             border-radius: 7px;*/
            box-sizing: border-box;
            color: #fff;
            height: 72px;
            width: 72px;
        }

        .twPc-divUser {
            margin: 5px 11px 0;
        }

        .twPc-divName {
            font-size: 18px;
            font-weight: 700;
            line-height: 21px;
        }

        .twPc-divName a {
            color: inherit !important;
        }

        .twPc-divStats {
            margin-left: 11px;
            padding: 10px 0;
        }

        .twPc-Arrange {
            box-sizing: border-box;
            display: table;
            margin: 0;
            min-width: 100%;
            padding: 0;
            table-layout: auto;
        }

        ul.twPc-Arrange {
            list-style: outside none none;
            margin: 0;
            padding: 0;
        }

        .twPc-ArrangeSizeFit {
            display: table-cell;
            padding: 0;
            vertical-align: top;
        }

        .twPc-ArrangeSizeFit a:hover {
            text-decoration: none;
        }

        .twPc-StatValue {
            display: block;
            font-size: 18px;
            font-weight: 500;
            transition: color 0.15s ease-in-out 0s;
        }

        .twPc-StatLabel {
            color: #8899a6;
            font-size: 10px;
            letter-spacing: 0.02em;
            overflow: hidden;
            text-transform: uppercase;
            transition: color 0.15s ease-in-out 0s;
        }

        .btn {

            border-radius: 10px;
        }

        .btnnn {
            border: 1px solid #3597B0;
            border-radius: 10px;
            background-color: white;
            color: black;
        }
        /* Blue */
        .info {
            border-color: #2196F3;
            color: dodgerblue;
        }
    </style>
@endsection
@section('contenttt')
    <div class="row">
        @if($user->followers->count() > 0)
            @foreach($user->followers as $f)
                <div class="col-md-4">
                    <!-- code start -->
                    <div class="twPc-div">
                        <a class="twPc-bg twPc-block"></a>

                        <div>
                            <a title="{{ $f->username }}" href="{{ url('/'.$f->username) }}"
                               class="twPc-avatarLink">
                                <img alt="{{ $f->username }}"
                                     src="{{ asset('public/uploads/avatar/'.$f->avatar) }}"
                                     class="twPc-avatarImg img-circle">
                            </a>

                            <br>
                            <div>
                                @if(Auth::check() && $f->id != Auth::user()->id)
                                    @if(Auth::user()->followings()->where('leader_id', $f->id)->get()->count() > 0)
                                        <button class="btn btn-danger btn-sm" style="margin-right: 56px;"
                                                onclick="event.preventDefault();
                                                        document.getElementById('follow-form-{{ $f->id }}').submit();">
                                            إلغاء المتابعة
                                        </button>
                                        <form id="follow-form-{{ $f->id }}"
                                              action="{{ url('/'.$f->username.'/unfollow') }}"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @else
                                        <button class="btn btnnn btn-info btn-sm" style="margin-right: 86px;"
                                                onclick="event.preventDefault();
                                                        document.getElementById('follow-form-{{ $f->id }}').submit();">
                                            تابع
                                        </button>
                                        <form id="follow-form-{{ $f->id }}"
                                              action="{{ url('/'.$f->username.'/follow') }}"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                @endif
                            </div>

                            <div class="twPc-divUser" style="margin-left: 10px">
                                <div class="twPc-divName">
                                    <a href="{{ url('/'.$f->username) }}">{{ str_limit($f->name,6) }}</a>
                                    @if($f->blue_mark == 1)
                                        <i class="fa fa-check-circle" style="color: #3597B0"
                                           data-toggle="tooltip"
                                           title="هذا الحساب موثّق"></i>
                                    @endif
                                </div>
                                <span>
                                                <a href="{{ url('/'.$f->username) }}">@<span>{{ str_limit($f->username,9) }}</span></a>
                                            </span>
                            </div>

                            <div class="twPc-divStats">
                                <ul class="twPc-Arrange">
                                    <li class="twPc-ArrangeSizeFit">
                                        <p>{{ ($f->bio != null) ? str_limit($f->bio,50) : 'لم يتم كتابة وصف' }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- code end -->
                </div>
            @endforeach
        @endif
    </div>
@endsection
@section('extraJS')
    <script>
        console.log('{{ (isset($message)) ? $message : '' }}');
    </script>
@endsection
