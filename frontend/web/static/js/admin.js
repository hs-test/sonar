
/***********************************/
/* Set Min-Height of Page Content */
function fixedHeight() {
    var viewportHeight = $(window).height();
    var pageSidebar = $('.page__sidebar-wrapper').height();

    if (viewportHeight < pageSidebar) {
        viewportHeight = pageSidebar;
    }
    if(viewportHeight > 850) {
        $('.page__content-inner').css('min-height', viewportHeight - 0 + 'px');
    }
}
;
fixedHeight();


/***********************************/
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
/* Resize function */

$(window).resize(function () {
    fixedHeight();
});