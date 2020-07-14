<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 8/28/2017
 * Time: 3:11 PM
 */ ?>

@extends('layouts.home')


@section('extraCss')
<style>
/* Slideshow container */
.slideshow-container {
  position: relative;
  background: #f1f1f1f1;
}

/* Slides */
.mySlides {
  display: none;
  padding: 80px;
  text-align: center;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -30px;
  padding: 16px;
  color: #888;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  position: absolute;
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
  color: white;
}

/* The dot/bullet/indicator container */
.dot-container {
  text-align: center;
  padding: 20px;
  background: #ddd;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

/* Add a background color to the active dot/circle */
.active, .dot:hover {
  background-color: #717171;
}

/* Add an italic font style to all quotes */
q {font-style: italic;}

/* Add a blue color to the author */
.author {color: cornflowerblue;}

</style>
@endsection

@section('content')
    <!-- search section -->
    <section class="search">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-10 col-xs-12 col-md-offset-3 text-center">
                    <div class="title">
                        <h3>ابحث مرة، تعلمها للأبد</h3>
                        <h4>أكبر موقع عربي لمُفردات إنجليزية</h4>
                    </div>
                    <form action="{{ url('/search') }}" method="get">
                        <div class="form-group">
                            <input type="text" name="q" class="form-control"
                                   placeholder="أدخل كلمة مراد بحث عنها...">
                        </div>
                    </form>
                    
                    
                    
                   
                         Slideshow container 
                         <h2 style="padding-top:20px;">أحدث التنبيهات  </h2>
                            <div class="slideshow-container">
                            
                              
                              
                             
                            
                              <div class="mySlides">
                                <p >
                                    {!! htmlspecialchars_decode($notice->notice_desc) !!} 
                                     </p>
                                
                           
                                    <p class="author">{{$notice->created_at}}</p>
                                  
                              </div>
                           
                               Next/prev buttons 
                              <a class="prev" style="left:0%" onclick="plusSlides(-1)">&#10094;</a>
                              <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            </div>
                            
                             Dots/bullets/indicators 
                            <div class="dot-container">
                              <span class="dot" onclick="currentSlide(1)"></span>
                              <span class="dot" onclick="currentSlide(2)"></span>
                              <span class="dot" onclick="currentSlide(3)"></span>
                            </div>
                        



                </div>
            </div>
        </div>
    </section>
@endsection


@section('extraJS')
<script>



var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}


</script>






@endsection