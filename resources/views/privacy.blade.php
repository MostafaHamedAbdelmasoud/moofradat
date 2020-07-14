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
    <section class="contact">
        <div class="container">
            <div class="page-header">
                <h3>{{ $title }}</h3>
            </div>

            <p>
                <?= html_entity_decode($privacy->page_content) ?>
            </p>
        </div>
    </section>



@endsection
