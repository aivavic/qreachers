//on first load
function preloadStart() {
	if(!Modernizr.cssanimations||!Modernizr.backgroundsize||!Modernizr.boxsizing||!Modernizr.csstransforms||!Modernizr.csstransitions){
		runDummy();
		return;
	}

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



function runDummy(){
	$('body').html('<div class="deprecated-box"> 	<div class="align db-align"> 		<span class="icon icon-window"><img src="/img/deprecated/window.png" alt="" /></span> 		<div class="db-text"><span class="bold">Ваш браузер устарел.</span> Сайт будет работать некорректно<div class="br"></div>  Чтобы исправить проблему, пожалуйста, обновите браузер <br /> на более позднюю версию или воспользуйтесь другим браузером.</div> 		<hr /> 		<a class="icon icon-browser-wrap"><span class="icon-text">Chrome</span><span class="icon"><img src="/img/deprecated/br_chrome.png" alt="" /></span></a> 	</div> </div>  <style type="text/css">  .deprecated-box, .deprecated-box *{ -webkit-box-sizing:content-box; -moz-box-sizing:content-box; box-sizing:content-box;}  .deprecated-box{ position:absolute; left:0; top:0; width:100%; height:100%; background:#00567d; font:18px/30px "pantonregular", Arial, sans-serif; color:#fff;}  .db-align{ text-align:center; width:600px; position:absolute; left:50%; top:50%; margin:-202px 0 0 -300px;}  .bold{ color:#dfe039; font-family: "pantonbold";}  .icon{ display:inline-block;}  .icon-window{ margin-bottom:30px;}  hr{ display:block; width:66px; height:2px; margin:auto; background:#e0e139; border-width:2px 0; border-style:solid; border-color:#69975d; margin:36px 0 48px;}  .icon-browser-wrap{ font:14px/20px "pantonregular"; text-decoration:none; color:#32c7fc;}  .icon-text{ display:inline-block;}  .icon-browser-wrap .icon-text{ display:block; margin-bottom:14px;}  .icon-browser-wrap:hover{ text-decoration:none; color:#fff;}  </style>            ');
}