<?php 
    $title = "تفعيل الاميل";
?>
@extends('layouts.other')

@section('content')
<br />
<br />

<br />
<br />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center" style="border: 1px solid #666; border-radius: 10px; padding: 30px; margin: 50px auto; max-width: 600px;">
                <div class="card-header">
تحقق من عنوان بريدك الإلكتروني</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

قبل المتابعة ، يرجى التحقق من بريدك الإلكتروني لمعرفة رابط التحقق. إذا لم تستلم البريد الإلكتروني ،
                    إذا لم تستلم البريد الإلكتروني ،
, <a href="{{ route('verification.resend') }}">انقر هنا للارسال مرة اخرة</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
