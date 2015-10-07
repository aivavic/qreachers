$(document).ready(function () {

	/* ajax height fix */

	heightFix();

	$(window).resize(function(){
		heightFix();
	});

	function heightFix(){
		$('.main_top').css({'height':$(window).height()});
		//console.log($(window).height());
	}
	
	
	var ng_userAgent=navigator.userAgent,
		ng_appVersion=parseInt(navigator.appVersion),
		ng_platform=navigator.platform;
	console.log(ng_userAgent);
	console.log(ng_appVersion);
	console.log(ng_platform);
	
});