var swiperBanner = new Swiper('.swiper-banner', {
	pagination: {
		el: '.swiper-banner .swiper-pagination',
	},
	slidesPerView: 1,
	spaceBetween: 0,
	loop: true,
	autoplay: {
		delay: 3000,
		disableOnInteraction: false,
	},
});

var swiperBlog = new Swiper ('.swiper-blog', {
  slidesPerView: 'auto',
  spaceBetween: 40,
  pagination: {
		el: '.swiper-blog .swiper-pagination',
		type: 'bullets',
		clickable: true,
	},
});