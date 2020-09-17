$(document).ready(function() {
	/* Top Navigation */
	$(window).on('resize', function() {
		if($(window).width() > 768) {
			$('.main-menu .menu-container').slideDown();
			$('.main-menu .sub-menu').slideDown();
			$('.main-menu .sub-menu').removeClass('open');
		}
	})
	
	$('.main-menu .toggle-menu').on('click', function() {
		$('.main-menu .menu-container').slideToggle();
	});

	$('.main-menu .menu-sub-container').on('click', function() {
		$('.main-menu .sub-menu').slideToggle();
		$(this).toggleClass('open');
	});

});