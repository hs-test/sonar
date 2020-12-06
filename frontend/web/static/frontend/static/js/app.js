
/***********************************/
/* Initalise */
/**********************************/
$(document).ready(function () {
    $('.two--slide').slick({
        dots: true,
        infinite: false,
        speed: 900,
        slidesToShow: 2, 
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            } 
        ]
    });  
    $('.home--slide').slick({
        dots: true,
        infinite: true,
        arrows: true,
        speed: 900,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToShow: 1 
    });   
    $('.homegallery--slide').slick({
        infinite: true,
        dots: false,
        arrows: false,
        slidesToShow: 4, 
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            } 
        ]
    });
    
});

 
 
 
/***********************************/
/* Sidebar Slide in on top */
/**********************************/
$('.menu-section').clone().appendTo('.standalone-menu');
$('.navigation__wrapper-menu-icon').on('click', function (event) {
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

var subMenu = $('.responsive-standalone li.dropdown');
if(subMenu) {
    subMenu.append("<span class='arrowIcon'><i class='fa fa-angle-down'></i></span>");
};

var accordianMenu = $('.responsive-standalone .menu-section > li.dropdown > span');
$(accordianMenu).removeClass('active').prev('.sub-menu').slideUp();
$(accordianMenu).on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    if ($(this).hasClass('active')) {
        $(this).removeClass('active').prev('.sub-menu').slideUp();
    }
    else {
        accordianMenu.removeClass('active').prev('.sub-menu').slideUp();
        $(this).addClass('active').prev('.sub-menu').slideToggle();
    };
});

var accordianSubMenu = $('.responsive-standalone .menu-section .sub-menu > li.dropdown > span');
$(accordianSubMenu).removeClass('active').prev('.sub-sub-menu').slideUp();
$(accordianSubMenu).on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    if ($(this).hasClass('active')) {
        $(this).removeClass('active').prev('.sub-sub-menu').slideUp();
    }
    else {
        accordianSubMenu.removeClass('active').prev('.sub-sub-menu').slideUp();
        $(this).addClass('active').prev('.sub-sub-menu').slideToggle();
    };
});





/* js for sidenav */
$(document).ready(function () {
    if ($(window).width() < 991) {
        $(".rightSidebar__wrapper h3 a").click(function () {
            $(this).parent().next(".rightSidebar__wrapper-content").slideToggle(500);
        });
    }; 
    //equalheight('.locateList');  
});  


$('#searchIcon').click(function () {
    $("#searchIcon span").toggleClass("fa-search fa-times");
    $('.searchBar').slideToggle();
});


$(function () {
    var dd = $('.verticleSlider').easyTicker({
        direction: 'up',
        speed: 'slow',
        interval: 3500,
        height: 'auto',
        visible: 3,
        mousePause: 0,
        controls: {
            up: '.up',
            down: '.down',
            toggle: '.toggle',
            stopText: 'Stop !!!'
        }
    })
    .data('easyTicker');  

});
