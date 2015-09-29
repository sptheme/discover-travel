jQuery(document).ready(function($){
	var $mobile_menu_trigger = $('#mobile-menu-trigger'),
		$content_wrapper = $('#page');

	//open-close mobile menu clicking on the menu icon
	$mobile_menu_trigger.on('click', function(event){
		event.preventDefault();
		
		$mobile_menu_trigger.toggleClass('is-clicked');
		$content_wrapper.toggleClass('mobile-menu-is-open').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			// firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
			$('body').toggleClass('overflow-hidden');
		});
		$('#sitemenu-container').toggleClass('mobile-menu-is-open');
		
		//check if transitions are not supported - i.e. in IE9
		if($('html').hasClass('no-csstransitions')) {
			$('body').toggleClass('overflow-hidden');
		}
	});

	//close mobile menu clicking outside the menu itself
	$content_wrapper.on('click', function(event){
		if( !$(event.target).is('#mobile-menu-trigger, #mobile-menu-trigger span') ) {
			$mobile_menu_trigger.removeClass('is-clicked');
			$content_wrapper.removeClass('mobile-menu-is-open').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				$('body').removeClass('overflow-hidden');
			});
			$('#sitemenu-container').removeClass('mobile-menu-is-open');
			//check if transitions are not supported
			if($('html').hasClass('no-csstransitions')) {
				$('body').removeClass('overflow-hidden');
			}

		}
	});

	//open (or close) submenu items in the mobile menu. Close all the other open submenu items.
	$('.menu-item-has-children').children('a').on('click', function(event){
		event.preventDefault();
		$(this).toggleClass('submenu-open').next('.sub-menu').slideToggle(200).end().parent('.menu-item-has-children').siblings('.menu-item-has-children').children('a').removeClass('submenu-open').next('.sub-menu').slideUp(200);
	});
});