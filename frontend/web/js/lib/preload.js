//on first load
function preloadStart() {
    runLoader();
}

//on first load end
function preloadLogoEnd() {

}

//on ajax link click
function preloadFadeIn() {
    var html = '<div class="preloader animated preloader_ajax_link">		<div class="preloader__wrap">			<div class="preloader__logo preloader__logo--spin animated"></div>		</div>		<div class="preloader__status animated"></div>	</div>';
    $('body').append(html);
}

//on ajax link click end
function preloadFadeOut() {
    $(".top__menu-btn-sandwich").click();    
    fOnLoaderComplete();
}

function runLoader() {
    $.html5Loader({
        filesToLoad: app.config.frontend_app_frontend_url + '/video/files.json',
        onUpdate: function (percentage) {
            $('.preloader__status').css({'width': percentage + '%'});
        },
        onComplete: fOnLoaderComplete
    });
}

var fOnLoaderComplete = function () {
    setTimeout(function () {
        $('.preloader__logo--spin').removeClass('preloader__logo--spin');
        $('.preloader__logo').addClass('fadeOutDown');
        $('.preloader__status').addClass('fadeOut');

        //document.getElementById('main_video1').play();

    }, 1250);

    setTimeout(function () {
        $('.preloader').addClass('slideOutUp');
    }, 2500);

    setTimeout(function () {
        $('.top__logo').addClass('fadeInUp');
        $('.top__lang').addClass('fadeInDownBig');
        $('.top__menu-btn').addClass('fadeInDownBig');

        $('.main_slider__cell h2').addClass('fadeInDown');
        $('.main_slider__cell .btn').addClass('fadeInUp');
    }, 3000);

    setTimeout(function () {
        $('.bullets__in').parent().addClass('bullets__nav--active');
        $('.scroll_arrow').addClass('scroll_arrow--active');
    }, 4000);
}