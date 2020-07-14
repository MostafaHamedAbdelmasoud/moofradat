
$(function(){
    'use strict';


    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
       /* if(scroll > 100)
        {
            $('.navbar-inverse').css('background-color' , '#273140');
            $('.navbar-inverse').css('border-color' , '#273140');
            $('.navbar-inverse .navbar-nav > li > a').css('color' , '#fff');
            $('.navbar-inverse .navbar-brand > img').css('height','30px');
        }else {
           /!* $('.navbar-inverse').css('background-color' , 'transparent');
            $('.navbar-inverse').css('border' , 'transparent');*!/
            $('.navbar-inverse .navbar-nav > li > a').css('color' , '#fff');
            $('.navbar-inverse .navbar-brand > img').css('height','45px');

        }*/
    });

    // tooltip for how-it-works page
    $('.nav-tabs > li a[title]').tooltip();

    // bootstrap tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // bootstrap popover
    $('[data-toggle="popover"]').popover();





    // scroll reveal
    // window.sr = ScrollReveal();
    // sr.reveal('.home-page h1 , .home-page p',{
    //     duration : 500,
    //     delay : 100,
    //     distance: '0px',
    // });
    // sr.reveal('.home-page .btn' , {
    //     duration : 800,
    //     delay : 200,
    //     distance : '0px'
    // } , 200);
    // sr.reveal('.contents .article-card , .contents .article-card figcaption',{
    //     duration : 500,
    //     delay : 100,
    //     distance: '0px',
    // } , 500);
    // sr.reveal('.company .company-img , .company .list-unstyled  , .company .page-header , .company  a',{
    //     duration : 800,
    //     delay : 500,
    //     distance: '0px',
    // });
    // sr.reveal('.how-works h3 , .how-works .embed-responsive',{
    //     duration : 800,
    //     delay : 200,
    //     distance: '0px',
    // } , 500);
    // sr.reveal('.features p i , .features p',{
    //     duration : 100,
    //     delay : 100,
    //     distance: '0px',
    // } , 100);

});
