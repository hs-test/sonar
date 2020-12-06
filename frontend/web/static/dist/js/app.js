
/* Sidebar Slide in on top */
/**********************************/
$('.page__sidebar').children().clone().appendTo('.responsive-standalone');
$('.open-menu').on('click', function (event) {
    event.preventDefault();
    $('body').addClass('noscroll');
    $('.responsive-standalone').addClass('navigation-active');
    $(".responsive-standalone-overlay").animate({
        "opacity": "toggle"
    }, {
        duration: 500
    }, function () {
        $(".responsive-standalone-overlay").fadeIn();
    });
    return false;
});
$('.responsive-standalone-close').on('click', function (event) {
    event.preventDefault();
    $('body').removeClass('noscroll');
    $('.responsive-standalone').removeClass('navigation-active');
    $(".responsive-standalone-overlay").hide();
    return false;
});
$(".responsive-standalone-overlay").on('click', function () {
    $('.responsive-standalone').removeClass('navigation-active');
    $(".responsive-standalone-overlay").hide();
    $('body').removeClass('noscroll');
});


/***********************************/
/* Dropdown switchery clickable function */
/**********************************/
$(".simple__menu li.switchery__click").on("click", function (e) {
    e.stopPropagation();
});

$('.section__sub-link').on('click', function() {
   $(this).toggleClass('active').parents('.section').next('.navigation-toggled').slideToggle();
});
/***********************************/
/* Slide drawer function */
/**********************************/        
$('.button-setting-panel').on('click', function (event) {
    event.preventDefault();
    $('body').addClass('noscroll');
    $('.SettingPanel').addClass('setting-active');
    $(".setting-overlay").animate({
        "opacity": "toggle"
    }, {
        duration: 500
    }, function () {
        $(".setting-overlay").fadeIn();
    });
    return false;
});
$('.SettingPanel__close').on('click', function (event) {
    event.preventDefault();
    $('body').removeClass('noscroll');
    $('.SettingPanel').removeClass('setting-active');
    $(".setting-overlay").hide();
    return false;
});
$(".setting-overlay").on('click', function () {
    $('.SettingPanel').removeClass('setting-active');
    $(".setting-overlay").hide();
    $('body').removeClass('noscroll');
});

/***********************************/
/* All dynamic class on body function */
/**********************************/   

//$('body').addClass(bodyClass);


/***********************************/
/* Dual login fade function */
/**********************************/   

$(".login__dualSection-content-first").on('click', function () {
    $(this).removeClass('blur-section');
    $(".login__dualSection-content-second").addClass('blur-section');
});
$(".login__dualSection-content-second").on('click', function () {
    $(this).removeClass('blur-section');
    $(".login__dualSection-content-first").addClass('blur-section');
});
  
$(".search__toggle #SearchToggle").on('click', function() {
   $(this).next(".searchblock").slideToggle(); 
});
/***********************************/

/***********************************/
/* select dropdown js */
/**********************************/

$(".chzn-select").chosen({width: '100%'});
//$(".chzn-search").chosen({width: '100%'});

/***********************************/
/* Switchery Toggle */
/**********************************/
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elems.forEach(function (html) {
    var switchery = new Switchery(html, {color: '#61ed92', secondaryColor: '#c0c4cb', jackColor: '#ffffff'});
});



/***********************************/
/* Enabling Edit */
/**********************************/
$('.overlay-edit').on('click', function () {
    $.each($('.editable_wrapper').find('.controls'), function (index, obj) {
        $(obj).removeClass('selected');
    });
    $(this).closest('.controls').addClass('selected');
});
/***********************************/
/* Noty js */
/**********************************/
function generate(layout) {

    var n = noty({
        text: layout,
        type: 'success',
        dismissQueue: true,
        layout: layout,
        timeout: 2000,
        theme: 'defaultTheme',
        animation: {
            open: 'animated bounceInRight',
            close: 'animated bounceOutRight',
            easing: 'swing',
            speed: 500
        }
    });
}


/***********************************/
/* Tabbing responsive function */
/**********************************/   
$(".tabbable__custom h3").on('click', function () {
    $(this).next('ul').toggleClass('open').slideToggle();
});
var toggleClassFinder = $(".tabbable__custom").find('ul');

$('body').on('click', function (e) {
    if (!$(e.target).hasClass('menuSlide')) {
        if (toggleClassFinder.hasClass('open')) {
            $(".tabbable__custom ul").removeClass('open').slideUp();
        }
    }
});

/* Sidebar Navigation */
var subMenu = $('.responsive-standalone .page__sidebar-standaloneNav-listing li.sub-children');
if(subMenu) { 
    subMenu.append("<span class='arrow'><i class='fa fa-angle-down'></i></span>");
};

var accordianMenu = $('.responsive-standalone .page__sidebar-standaloneNav-listing > li.sub-children > a > .arrow');
$(accordianMenu).removeClass('active').prev('.sub-nav').slideUp();
$('.childMenuArrow').on('click', function (e) { 
    e.preventDefault();
    e.stopPropagation();
    if ($(this).hasClass('active')) {
        $(this).removeClass('active').prev('.sub-nav').slideUp();
    }
    else {
        accordianMenu.removeClass('active').prev('.sub-nav').slideUp();
        $(this).addClass('active').prev('.sub-nav').slideToggle();
    };
});

var accordianSubMenu = $('.responsive-standalone .page__sidebar-standaloneNav-listing .sub-nav > li.sub-children .arrow');
$(accordianSubMenu).removeClass('active').prev('.sub-sub-nav').slideUp();
$(accordianSubMenu).on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    if ($(this).hasClass('active')) {
        $(this).removeClass('active').prev('.sub-sub-nav').slideUp();
    }
    else {
        accordianSubMenu.removeClass('active').prev('.sub-sub-nav').slideUp();
        $(this).addClass('active').prev('.sub-sub-nav').slideToggle();
    };
});



$('.skew-menu').on('click', function() {
   $('body').toggleClass('nav-small'); 
   $(".responsive-standalone-overlay").hide();
});

$(document).ready(function () {
    $('.section_head__accordian').on('click', function (e) {
        e.preventDefault();
        $(this).next().slideToggle();
        $(this).toggleClass("active");
        setTimeout(function () {
            $(".table__structure-scrollable .scrolling").getNiceScroll().resize().show();
        }, 500);
    });
});

$(document).ready(function(e) {
    $('img[usemap]').rwdImageMaps();
});

var setToolTip = function() {

    $('.masterTooltip').hover(function(){
            // Hover over code
            var title = $(this).attr('title');
            $(this).data('tipText', title).removeAttr('title');
            $('<p class="tooltip-custom"></p>')
            .html(title)
            .appendTo('body')
            .fadeIn('slow');
    }, function() {
            // Hover out code
            $(this).attr('title', $(this).data('tipText'));
            $('.tooltip-custom').remove();
    }).mousemove(function(e) {
            var mousex = e.pageX + 20; //Get X coordinates
            var mousey = e.pageY + 10; //Get Y coordinates
            $('.tooltip-custom')
            .css({ top: mousey, left: mousex })
    });
}
$(document).ready(function(e) {
    setToolTip();
});