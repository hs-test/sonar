
/***********************************/
/* Set Min-Height of Page Content */
function fixedHeight() {
    var viewportHeight = $(window).height();
    var pageSidebar = $('.page__sidebar-wrapper').height();

    if (viewportHeight < pageSidebar) {
        viewportHeight = pageSidebar;
    }
    $('.page__content-section').css('min-height', viewportHeight - 50 + 'px');
    $('.page__content-inner').css('min-height', $(document).height());
}
;
fixedHeight();

/***********************************/
/* Nice scroll for table scrolling */
/**********************************/
$(".table__structure-scrollable .scrolling").niceScroll();

function toggleIcon(e) {
    $(e.target)
            .prev('.panel-heading')
            .find(".arrow")
            .toggleClass(' fa-angle-down  fa-angle-up');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
    
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

$(".sectionContent .viewDetail a").on('click', function() {
    $(this).parents('.permissionBody').children('.sectionInfo').toggleClass('hide');
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
/* Resize function */

$(window).resize(function () {
    fixedHeight();
});
/***********************************/
/* select dropdown js */
/**********************************/

$(".chzn-select").chosen({width: '100%'});

/***********************************/
/* Date Picker js */
/**********************************/

$('.datetimepicker4').datepicker({
   
});

$('#multiSectionSelect').selectpicker('refresh');

/***********************************/
/* Switchery Toggle */
/**********************************/
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elems.forEach(function (html) {
    var switchery = new Switchery(html, {color: '#61ed92', secondaryColor: '#c0c4cb', jackColor: '#ffffff'});
});

/***********************************/
/* Tooltip js */
/**********************************/

$('[data-toggle="tooltip"]').tooltip();


/***********************************/
/* Tipped function */

Tipped.create('.tipped', '', { showOn: 'click', hideOn: 'click', hideOnClickOutside: true });

/* Sidebar Navigation */

var toggle = false;
$('.page__sidebar-standaloneNav-listing li.sub-children').on('click', function(e) {  
    if(toggle) {
        return;
    }
    e.preventDefault();
    e.stopPropagation();
    var elem = $(this);
    var subMenu = $(elem).find('ul');
    if(subMenu.hasClass('open')){
        subMenu.removeClass('open');
        subMenu.slideUp();
        $('li.sub-children').find('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
    }
    else {
        $('.sub-nav').removeClass('open');
        $('.sub-nav').slideUp();
        $('li.sub-children').find('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
        subMenu.addClass('open');
        subMenu.slideToggle();
        $(elem).find('.arrow').removeClass('fa-angle-down').addClass('fa-angle-up');
    } 
});

$('.page__sidebar-standaloneNav-listing li.sub-children ul li a').on('click', function(e) {
    toggle = true;
});



$('.skew-menu').on('click', function() {
   $('body').toggleClass('nav-small'); 
   $(".responsive-standalone-overlay").hide();
});

$(".only-alphabet").on("keypress", function (e) {

    var code = (e.which) ? e.which : event.keyCode;
    if (code == 32 || code == 8 || (code >= 97 && code <= 122) || (code >= 65 && code <= 90))
        return true;
    else
        return false;
});

$(".only-number").on("keypress", function (e) {

    var charCode = (e.which) ? e.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    else
        return true;
});


