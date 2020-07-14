<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/24/2017
 * Time: 8:35 PM
 */ ?>
@extends('layouts.other')

@section('content')


    <!-- contact section  -->
    <section class="contact">
        <div class="container">
            <div class="page-header">
                <h3>{{ $title }}</h3>
            </div>

            <p>
                <strong>{{ $content }}</strong>
            </p>
        </div>
    </section>



@endsection