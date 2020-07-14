<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>
<style>
.border-lable-flt {
  display: block;
  position: relative;
}
.border-lable-flt label, .border-lable-flt > span {
  position: absolute;
  right: 0;
  top: 0;
  cursor: text;
  font-size: 100%;
  opacity: 1;
  -webkit-transition: all .2s;
          transition: all .2s;
  top: -.5em;
  right: 0.75rem;
  z-index: 3;
  line-height: 1;
  padding: 0 1px;
  color: turquoise;
}
.border-lable-flt label::after, .border-lable-flt > span::after {
  content: " ";
  display: block;
  position: absolute;
  background: white;
  height: 2px;
  top: 50%;
  left: -.2em;
  right: -.2em;
  z-index: -1;
}




.input-group .border-lable-flt {
  display: table-cell;
}
.input-group .border-lable-flt .form-control {
  border-radius: 0.25rem;
}
.input-group .border-lable-flt:not(:last-child), .input-group .border-lable-flt:not(:last-child) .form-control {
  border-bottom-right-radius: 0;
  border-top-right-radius: 0;
  border-right: 0;
}
.input-group .border-lable-flt:not(:first-child), .input-group .border-lable-flt:not(:first-child) .form-control {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
}

.contact .form-control:not(textarea) {
    height: 50px;
    border-radius: 0;
    border-color: black;
    padding: 32px 12px 
}
</style>
@extends('layouts.other')

@section('content')
    <!-- contact section  -->
    <section class="contact">
        <div class="container" style="
    background-color: white;
    min-height: 1366px;
    padding:100px;
    border: solid 2px #3597b0;margin-top:60px">
            
          
              
       <div style="position:absolute; top:16%; right:15%;z-index:999999;background-color:rgba(255,255,255,0.8);">
    <img src="{{ asset('public/uploads/images/').'/'.$logo }}" width:"70px" height="60px">
    </div>
            
    
            <div class="page-header">
                <h3 style="
    text-align: right;color:black;">{{ $title }}</h3>
            </div>

    
            @if(session('message'))
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-block {{ session('type') }} fade in">
                            <button type="button" class="close" data-dismiss="alert"></button>
                            <span>{{ session('message') }}</span>

                            <br>
                            @if(count( $errors ) > 0)
                                @foreach ($errors->all() as $error)
                                    <div>- {{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif


         
            <br><br>
            <form action="{{ url('/contactus') }}" method="post">
                {{ csrf_field() }}
                <div class="row ">
                    
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                         
                             <label class="form-group border-lable-flt">
                            <input type="text" name="sender_name" class="form-control" required="" placeholder="الاسم">
                            <span style="color:black;">الاسم</span>
                      </label>
                        </div>
                        <div class="form-group">
                         
                              <label class="form-group border-lable-flt">
                            <input type="email" name="sender_email" class="form-control" required=""placeholder="البريد الالكتروني">
                            <span style="color:black;">البريد الالكتروني</span>
                            </label>
                        </div>
                     <div class="form-group">
                             <label class="form-group border-lable-flt">
                            <input name="msg_content"  class="form-control" placeholder="نص الرسالة">
                            <span style="color:black;">نص الرسالة</span>
                            </label>
                        </div>
                    </div>
                   
                </div>
                <div class="row text-center">
                    <div class="col-md-12 text-center" style="margin-top:30px;">
                        <button type="submit" class="btn  btn-info m-auto" style="width:30%; background-color:#3597b0;">إرسال</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
