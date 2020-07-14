<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/24/2017
 * Time: 8:35 PM
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
.contact{
    background-color:white;
}
</style>
@extends('layouts.other')

@section('content')










         
    
     <section class="contact register" style="text-align:center;">
        <div class="container"  style="
    background-color: white;
    min-height: 666px;
    border: solid 5px #3597b0;margin-top:60px;position:relative;text-align:center;padding:150px 0px 0px 0px;">
            
            
            <div class="page-header">
                <h3 style="text-align: center;color:black;"> لتأكد من عمل الحساب الخاص بك بشكل صحيح  </span></h3>
                    <p style="color:black; padding-right:35px">قمنا بإرسال رمز التحقق إلى </p>
                     <p style="color:black; padding-right:35px">{{session('mail')}}</p>
            </div>


            @if(session('message'))
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
            
     <!--<form action="{{ url('/user/login') }}" method="post">-->
                 <form action="{{ url('user/verify-account') }}" method="post">

                {{ csrf_field() }}
                <div class="row" style="margin: auto;width: 60%; padding-top:20px;">
                   
                   
                   
                   <div class="col-lg-12 col-xs-12" >
                       
                       
                       
                       <div class="form-group d-none" style="display:none;">
                            
                               <label class="form-group border-lable-flt">
                          
                            <input type="email"  name="email" class="form-control d-none"  value="{{session('mail')}}"
                                   placeholder=" ">
                                    <span style=" color:black;">البريد الإلكتروني </span>
                                   </label>
                            
                            
                        </div>
                       
                       
                        <div class="form-group">
                            
                               <label class="form-group border-lable-flt">
                          
                            <input type="text" name="code" class="form-control" required=""
                                   placeholder="كود التفعيل">
                                    <span style=" color:black;">كود التفعيل</span>
                                   </label>
                            
                            
                        </div>

                        

                        <div class="row" style="padding-top:20px;">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-info"
                                        style="background-color: #3597B0;border: solid 1px #3597B0;">التحقق
                                </button>
                            </div>
                        </div>
                        
                        
                         <h3 style="text-align: center;color:black;font-size:20px;">
إذا لم يصلك رمز التفعيل خلال 10 دقائق
،
<a href="https://twitter.com/moofradat">
 
 راسلنا لتنشيط
حسابك
     </a>
     
     
     </h3>
                        

                    </div>
                </div>

               
                </div>
            </form>


    
     

        </div>
    </section>
    
    
    
    
    



























@endsection