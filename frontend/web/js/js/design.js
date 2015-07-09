$(window).load(function(){
	var body = document.body,
	    timer,
	    hover_disabled = false;

	window.addEventListener('scroll', function() {
	  clearTimeout(timer);
	  if( ! hover_disabled && ! body.classList.contains('disable-hover')) {
	    body.classList.add('disable-hover');
	    hover_disabled = true;
	  }
	  
	  timer = setTimeout(function(){
	    body.classList.remove('disable-hover');
	    hover_disabled = false;
	  }, 200);
	}, false);
});

new WOW().init({
	mobile: false,
});

$(document).ready(function() {

	// Main page case slider
	if($('.projects_box__in').length) {
		$('.projects_box__in').flexslider({
			slideshow: false,
			directionNav: false,
			controlNav: false,
			start: function(slider) {
			    $('.projects_box .trio_nav__left').click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget('prev'));
				});

				$('.projects_box .trio_nav__right').click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget('next'));
				});
			}
		});
	}


	// Main page news slider
	if($('.news_box__in').length) {
		$('.news_box__in').flexslider({
			slideshow: false,
			directionNav: false,
			controlNav: false,
			start: function(slider) {
			    $('.news_box .trio_nav__left').click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget('prev'));
				});

				$('.news_box .trio_nav__right').click(function(event){
			        event.preventDefault();
			        slider.flexAnimate(slider.getTarget('next'));
				});
			}
		});
	}


	// Page filters
	/*if($('.top_filters__multi').length) {
		$('.top_filters__multi').hide();

		$('.top_filters__sort li').click(function(){
			$(this).toggleClass('asc').toggleClass('desc');
			$('.top_filters__multi').slideToggle(300);
		});

		$('.top_filters__multi li').click(function(){
			$(this).toggleClass('active');
		});
	}*/

	// Cases show/hide description
	/*if($('.projects_box__txt p').length) {
		$('.projects_box__item').hover(function(){
			$(this).find('.projects_box__txt p').slideToggle(250);
		});
	}*/


	// Case page slider
	if($('.case_page__slider-in').length) {
		$('.case_page__slider-in').flexslider();
	}


	// Case page height title
	function btitle_name() {
		if($(document).width() >= 767) {

			$('.btitle_name').each(function(){
			  var btitle_height = $(this).parent().parent().find('.btitle_name__body').height() - 15;
				$(this).css({height: btitle_height});
			});

		} else {
			$('.btitle_name').css({'height':'auto;'})
		}
	}

	if($('.btitle_name').length) {
		btitle_name();

		$(window).resize(function(){
			btitle_name();
		});
	}

	/*
	// Bullets nav
	$('.bullets__nav').onePageNav({
		scrollOffset: 100,
	    currentClass: 'active',
	    changeHash: true,
	    scrollSpeed: 1000,
	    easing: 'swing',
	    //scrollChange: true,

	    begin: function() {
        	$('body').append('<div id="device-dummy" style="height: 1px;"></div>');
	    },
	    end: function() {
	        $('#device-dummy').remove();
	    }

	});
	*/


	// Main slider
//	if($('.main_slider').length) {
//		$('.main_slider').flexslider({
//			//smoothHeight: true,
//			slideshow: false,
//		});
//	}

	$('.top__menu-btn').click(function(){

		if($(window).scrollTop() > 100) {
			if($('.top').hasClass('top--fixed')) {
				$('.top').removeClass('top--fixed');
			} else {
				$('.top').addClass('top--fixed');
			}
		}
	
		$('.top__lang').toggleClass('top__lang--menu');
		$('.top__logo').removeClass('animated').removeClass('fadeInUp');
		
		$(this).toggleClass('top__menu-btn--default');
		$(this).toggleClass('top__menu-btn--close');
		$('.main_menu').fadeToggle(250);
		$('.top__logo-full').toggleClass('top__logo-full--active');
		$('.top__logo').toggleClass('top__logo--active');
		$('.main_menu .main_menu__links').toggleClass('fadeInDown');
		$('.main_menu .main_menu__socials li').toggleClass('fadeInUp');

		$('body').toggleClass('lock');
	});


	// Trio nav
	if($('.trio_nav').length) {
		$('.trio_nav').hover(function(){
			$(this).addClass('trio_nav--hovered');
		});
	}

	if($('.trio_nev').length) {
		$('.trio_nev').hover(function(){
			$(this).addClass('trio_nev--hovered');
		});
	}


	// About page count
	/*if($('.countto').length) {
		$('.countto').appear(function() {
			$('.countto__number').each(function() {
				var count_element = $(this).html();
				$(this).countTo({
					from: 0,
					to: count_element,
					speed: 750,
					refreshInterval: 50,
				});
			});
		});
	}*/

	/*setTimeout(function() {
		//$('.trio_nav').addClass('trio_nav--active');
		$('.bullets__nav').addClass('bullets__nav--active');
		$('.scroll_arrow').addClass('scroll_arrow--active');
	}, 800);*/

/*
	// Contacts box
	$('.contacts_box__default-btn .flip-btn').click(function(){
		$('.contacts_box').addClass('flip');
		//$('.wrapper').animate({'height':'500px'}, 250);
	});

	$('.contacts_box__feedback--cancel').click(function(){
		$('.contacts_box').removeClass('flip');
		//$('.wrapper').animate({'height':'400px'}, 250);

		$('#contact_form').validate().resetForm();
	});

	/*$('.contacts_box__feedback--submit').click(function(){
		$('.flip-panel').fadeOut(300, function(){
			$('.contacts_box__thanks').fadeIn(300);
		});

		setTimeout(function() {
			$('.hover').removeClass('flip');
			$('.contacts_box__thanks').fadeOut(250, function(){
				$('.wrapper').animate({'height':'400px'}, 250);
				$('.flip-panel').fadeIn(300);
			})
		}, 3000);

	});*/

	// Validate contact form
/*	if($('#contact_form').length) {

		$('#contact_form').validate({
			//debug: true,
			errorClass: 'inp-error',
			errorElement: 'p',

			highlight: function (element, errorClass, validClass) { 
	            $(element).addClass(errorClass).removeClass(validClass); 
	        }, 
	        
	        unhighlight: function (element, errorClass, validClass) { 
	            $(element).removeClass(errorClass).addClass(validClass); 
	        },

			rules: {

				mail: {
					required: true,
					email: true
				},
				msg: {
					required: true,
					minlength: 2
				},
			},
			messages: {

				mail: "Введите корректные данные",
				msg: {
					required: "Введите ваше сообщение",
					minlength: "Сообщение должно быть больше двух символов"
				},

			},

			submitHandler: function(form) {
				$('.contacts_box__feedback').fadeOut(300, function(){
					$('.contacts_box__thanks').fadeIn(300);
				});

				setTimeout(function() {
					$('.contacts_box').removeClass('flip');
					$('.contacts_box__thanks').fadeOut(250, function(){
						$('.contacts_box__feedback').fadeIn(300);
						//$('.wrapper').animate({'height':'400px'}, 250);
					});

					//alert('Submitted!');

				}, 3000);

			}

		});
	}
*/

/*var arr_scrollheight = $(document).height();
var arr_scrollwinheight = $(window).height();

$(window).scroll(function() {

	var scrl_top = $(window).scrollTop();
   
	// Top menu add bg
	if(scrl_top > 100) {
		$('.top').addClass('top--fixed');
	} else {
		$('.top').removeClass('top--fixed');
	}


	// ScrollTop arrow event
	$('.scroll_arrow').click(function(){
		$('html, body').animate({ScrollTop: arr_scrollwinheight}, 300);
	});

	// Switch arrow up/down
	if((scrl_top + arr_scrollwinheight + 500) > arr_scrollheight) {
		$('.scroll_arrow').css({opacity: 1});
		$('.scroll_arrow').removeClass('scroll_arrow--active').addClass('scroll_arrow--up');
	} else {
		$('.scroll_arrow').removeClass('scroll_arrow--up');
	}

});
*/
	
});

