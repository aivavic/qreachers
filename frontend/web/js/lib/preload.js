//on first load
function preloadStart() {
    runLoader();
}

//on first load end
function preloadLogoEnd() {

}

//on ajax link click
function preloadFadeIn() {
    var html = '<div class="preloader preloader_ajax_link">		<div class="preloader__wrap">			<div class="preloader__logo preloader__logo--spin animated"></div>		</div>		<!--<div class="preloader__status animated"></div>-->	</div>';
    $('body').append(html);
	setTimeout(function(){
		$('.preloader').addClass('active');
	}, 20);
}

//on ajax link click end
function preloadFadeOut() {
    //$(".top__menu-btn-sandwich").click();
    fOnLoaderComplete();
    
    if ($('body').hasClass('lock')){
      $('body').removeClass('lock'); 
    }
    
    if ($('.main_menu').css('display') == 'block'){
      $('.main_menu').hide(); 
    }
    
    if ($('.top__menu-btn').hasClass('top__menu-btn--close')){
      $('.top__menu-btn').removeClass('top__menu-btn--close');
    }
    
    if (!$('.top__menu-btn').hasClass('top__menu-btn--default')){
      $('.top__menu-btn').addClass('top__menu-btn--default');        
    }

}

function runLoader() {
    $.html5Loader({
        filesToLoad: app.config.frontend_app_frontend_url + '/video/files.json',
        onUpdate: function (percentage) {
            $('.preloader__status').css({'width': percentage + '%'});
        },
        onComplete: fOnLoaderComplete
    });
	$('.preloader').addClass('pl-1 active');
	setTimeout(function(){
		$('.top__lang').removeClass('fadeInDownBig');
	}, 500);
}

var fOnLoaderComplete = function () {
    setTimeout(function () {
        $('.preloader__logo--spin').removeClass('preloader__logo--spin');
        $('.preloader__logo').addClass('fadeOutDown');
        $('.preloader__status').addClass('fadeOut');
		
		$('.top__lang').addClass('fadeInDownBig');

        //document.getElementById('main_video1').play();
		
		
		$('.top__logo-full').removeClass('top__logo-full--active');
		$('.top__logo').removeClass('top__logo--active');

		setTimeout(function () {
			/*$('.preloader').addClass('slideOutUp');*/
			$('.preloader').removeClass('pl-1 active');
		}, 1000);

    }, 1250);

    setTimeout(function () {
        /*$('.top__logo').addClass('fadeInUp');*/
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