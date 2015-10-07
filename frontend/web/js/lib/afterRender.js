$(document).ready(function () {

	/* ajax height fix */

	heightFix();

	$(window).resize(function(){
		heightFix();
	});

	function heightFix(){
		$('.main_top').css({'height':$(window).height()});
		console.log($(window).height());
	}
	
});