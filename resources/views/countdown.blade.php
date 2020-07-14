<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 12/30/2018
 * Time: 7:30 PM
 */ ?>


        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنتظرونا - مفردات</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/countdown/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/countdown/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/countdown/css/iosoon-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/countdown/css/iosoon-theme4.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-countdown/2.1.0/css/jquery.countdown.css">

</head>
<body>
<div class="form-body">
    <div class="row">
        <div class="img-holder">
            <div class="info-holder">
                <img src="{{ asset('/public/countdown/images/graphic3.svg') }}" alt="">
            </div>
        </div>
        <div class="form-holder">
            <div class="website-logo">
                <a href="#">
                    <div class="logo">
                        <img class="logo-size" src="{{ asset('public/uploads/images/').'/'.$logo }}" alt="">
                    </div>
                </a>
            </div>
            <div class="other-links other-links-up no-bg-icon">
                <a href="https://twitter.com/moofradat"><i class="fab fa-twitter"></i></a>
                <a href="https://twitter.com/_dosarii_"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="form-content">
                <div class="form-items text-center">
                    <h3>سنعود بحله جديدة</h3>
                    <p>سنكون معكم قريباً بشيء من الخيال</p>
                    {{--<form class="form-row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="E-mail Address">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Notify me</button>
                        </div>
                    </form>--}}
                    <hr>
                    <div class="spacer"></div>
                    <div class="time-counter form-row">
                        <div class="days count col">
                            <div class="num" id="day"></div>
                            <div class="label">أيام</div>
                        </div>
                        <div class="hours count col">
                            <div class="num" id="hour">13</div>
                            <div class="label">ساعة</div>
                        </div>
                        <div class="minutes count col">
                            <div class="num" id="minute"></div>
                            <div class="label">دقيقة</div>
                        </div>
                        <div class="seconds count col">
                            <div class="num" id="second"></div>
                            <div class="label">ثانية</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/public/countdown/js/jquery.min.js') }}"></script>
<script src="{{ asset('/public/countdown/js/popper.min.js') }}"></script>
<script src="{{ asset('/public/countdown/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/countdown/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-countdown/2.1.0/js/jquery.countdown-ar.min.js"></script>


</body>
</html>