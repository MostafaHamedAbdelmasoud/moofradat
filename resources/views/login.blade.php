
@extends('layouts.other')




@section('extraCss')
    <style>
        #pass{
            position:relative;
        }
        #showEye{
            position:absolute;
            right:90%;
            top:40%;
            width:10%;
            cursor:pointer;
            border-right:solid 0.5px black;
        }
        
        @media screen and (max-width:700px){
                #showEye{
                position:absolute;
                right:80%;
                top:40%;
                width:10%;
                cursor:pointer;
                border-right:solid 0.5px black;
            }
        }
    </style>
@endsection

@section('content')

    
    
     <section class="contact register" style="text-align:center;">
        <div class="container"  style="
    background-color: white;
    min-height: 666px;
    border: solid 5px #3597b0;margin-top:60px;position:relative;text-align:center;padding:150px 0px 0px 0px;">
            
            
            <div class="page-header">
                <h3 style="text-align: center;color:black;"> أهلا بك مرة أخرى على موقع مفردات <span style="color:#3597b0">موقع مفردات</span></h3>
<!--<p style="color:black; padding-right:35px">عندما تقوم بالتسجيل ستتمكن من اظافة كلمات</p>-->
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
     <form action="{{ url('/user/login') }}" method="post">
                {{ csrf_field() }}
                <div class="row" style="margin: auto;width: 60%;">
                   
                   
                   
                   <div class="col-lg-12 col-xs-12" >
                       
                       
                       
                        <div class="form-group">
                            
                             <label class="form-group border-lable-flt">
                            <input type="text" name="email" class="form-control" required="" laceholder="البريد الإلكتروني/إسم المستخدم">
                            <span style="color:black;"> الإسم / البريد الإلكتروني</span>
                            </label>
                            
                            
                        </div>

                        <div class="form-group">
                            <!--{{--<label for="">الاسم</label>--}}-->
                            
                        
                              <label class="form-group border-lable-flt">
                           <input id="pass" type="password" name="password" class="form-control" required="" placeholder="كلمة المرور">
                                <p id="showEye" style="color:black;">إظهار</p>
                                
                            <span style="color:black;">كلمة المرور</span>
                            </label>
                            
                        </div>

                        <div class="row" style="padding-right: 35px">
                            <div class="col-md-6">
                                <input type="checkbox" name="remember" id="">
                                تذكرني
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('/forget-password') }}">نسيت كلمة المرور ؟</a>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-info"
                                        style="background-color: #3597B0;border: solid 1px #3597B0;">إرسال
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

               
                </div>
            </form>


        </div>
    </section>
    
    
    
    
    
    
    



@endsection



@section('extraJS')


<script type='text/javascript'>
        $(document).ready(function(){
            $('#showEye').click(function(){
                if($("#pass").attr('type') == "text"){
                    $('#pass').attr('type', 'password');
                    $("#showEye").html('إظهار')
                }
                else{
                    $('#pass').attr('type', 'text');
                    $("#showEye").html('إخفاء')
                }
                // $("#pass").attr('type') == "text"? $('#pass').attr('type', 'password') : $('#pass').attr('type', 'text');
            });
        });
    </script>



@endsection



























