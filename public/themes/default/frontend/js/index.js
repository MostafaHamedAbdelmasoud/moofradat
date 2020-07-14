$(function(){
    'use strict';
    // tooltip for how-it-works page
    $('.nav-tabs > li a[title]').tooltip();

    // bootstrap tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // bootstrap popover
    $('[data-toggle="popover"]').popover();
})