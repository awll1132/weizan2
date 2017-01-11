$(function(){
		   
	
	
	var navSwiper = $('.swiper-nav').swiper({
		visibilityFullFit: true,
		slidesPerView:'auto',
		initialSlide :sid
		
	})

	//Update Nav Position
	function updateNavPosition(){
		$('.swiper-nav .active-nav').removeClass('active-nav')
		var activeNav = $('.swiper-nav .swiper-slide').eq(contentSwiper.activeIndex).addClass('active-nav')
		if (!activeNav.hasClass('swiper-slide-visible')) {
			if (activeNav.index()>navSwiper.activeIndex) {
				var thumbsPerNav = Math.floor(navSwiper.width/activeNav.width())-1
				navSwiper.swipeTo(activeNav.index()-thumbsPerNav)
			}
			else {
				navSwiper.swipeTo(activeNav.index())
			}	
		}
	}
		
	//document.getElementById("abc").onload = function() {aaa()};
})
