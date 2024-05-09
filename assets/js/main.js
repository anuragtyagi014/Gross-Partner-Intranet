Number.prototype.format = function (n) {
	var r = new RegExp('\\d(?=(\\d{3})+' + (n > 0 ? '\\.' : '$') + ')', 'g');
	return this.toFixed(Math.max(0, Math.floor(n))).replace(r, '$&.');
};

var website = {

	body: null,
	last_scroll_top: 0,
	small_header_limit: 10,
	translations: {},
	video_timeout: null,
	map_dots: {},
	scrollMagicScenes: [],
	projectCarouselTimeout: 3000,
	projectCarouselSpeed: 750,

	init: function () {
		website.initVariables();
		website.initNavigation();
		website.initFooter();
		website.initCarousels();
		website.initStage();
		website.initForms();
		website.initMoreText();
		website.initAccordion();
		website.initFluffyAnimations();
		website.initMasonries();
		website.initCalendarTooltips();
		website.initNewsOverview();
		website.initOnepager();

		$(window).resize(website.initWindowResizes);
		$(window).scroll(website.initWindowScrolls);
		$(window).trigger('resize');
		$(window).trigger('scroll');
		objectFitVideos();
		setInterval(website.initCalendarTooltips, 500);
		setInterval(website.initNewsOverview, 500);
	},

	initVariables: function () {
		website.translations = translations;
		website.body = $('body');
		website.last_scroll_top = $(window).scrollTop();
		website.controller = new ScrollMagic.Controller();
		var vh = window.innerHeight * 0.01;
		document.documentElement.style.setProperty('--vh', `${vh}px`);
		if (website.isTouchDevice()) {
			$('html').addClass('is-touch-device');
		}
	},

	isSafari: function(){
		var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
		return isSafari;
	},

	initFluffyAnimations: function () {
		var controller = website.controller;
		var window_height = $(window).height();
		if($(window).width() < 1025){
			if(navigator.platform == 'iPhone' || navigator.platform == 'iPod' || navigator.platform == 'iPad'){
				if (website.isSafari()) {
					window_height = window.innerHeight;
				}
			}
		}

		var selectors = '';

		selectors = 'header .navigation';
		selectors += ', .block-stage';
		$(selectors).each(
			function(){
				var el = this;
				$(el).addClass('show');
			}
		);

		selectors = '.block-google-search';
		selectors += ', .block-text';
		selectors += ', .block-news-press-review';
		selectors += ', .block-back-to-parent-page';
		selectors += ', .block-news-overview';
		selectors += ', .press-review-sec';

		$(selectors).each(
			function(){
				var el = this;
				$(el).addClass('show');
				var offset = 0;
				var scene = new ScrollMagic.Scene({
					'triggerElement': el,
					'offset': offset,
					'triggerHook': 0
				})
				.on('enter',
					function (event) {
						$(el).addClass('show');
					}
				)
				// .addIndicators()
				.addTo(controller);
				website.scrollMagicScenes.push(scene);
			}
		);

		/*
		$(elements).each(
			function () {
				var el = this;
				var text_block = $(el).parents('.block-text');
				var stage_block = $(text_block).prev('.block-stage').eq(0);
				var background = $(stage_block).find('.bg');
				var offset = 0;
				$(el).attr('data-top', $(el).css('top').replace('px', '') * 1);
				var diff = (window_height / 4);
				var duration = window_height - $(el).attr('data-top') * 1;
				$(text_block).addClass('stage-animation');

				// pin headline
				var scene = new ScrollMagic.Scene({
					'triggerElement': stage_block,
					'offset': offset,
					'triggerHook': 0,
					'duration': duration
				})
				.setPin(el, {
					'pushFollowers': false
				})
				.on('progress',
					function (event) {
						// var bg_pos = 100 + (event.progress * 10);
						// $(background).css('transform', 'translate3d(0,'+(-1 * (event.progress * 10))+'vh,0)');
					}
				)
				// .addIndicators()
				.addTo(controller);
				website.scrollMagicScenes.push(scene);

				// show contents of text block
				offset =  (-1 * $(el).attr('data-top') - 20) * 2; //  - ($(text_block).outerHeight() / 2)
				if(window_height < 768){
					offset =  (-1 * $(el).attr('data-top') - 20);
				}
				scene = new ScrollMagic.Scene({
					'triggerElement': text_block,
					'offset': offset,
					'triggerHook': 0
				})
				.on('enter',
					function (event) {
						$(text_block).addClass('show');
					}
				).on('leave',
					function (event) {
						$(text_block).removeClass('show');
					}
				)
				// .addIndicators()
				.addTo(controller);
				website.scrollMagicScenes.push(scene);



				// hide red border-top of text-block
				offset = (-1 * $(el).attr('data-top')) - $(el).offset().top - (2 * $(el).outerHeight()); //  - ($(text_block).outerHeight() / 2)
				scene = new ScrollMagic.Scene({
					'triggerElement': text_block,
					'offset': offset,
					'triggerHook': 0
				})
				.on('enter',
					function (event) {
						$(text_block).addClass('hide-border-top');
					}
				).on('leave',
					function (event) {
						$(text_block).removeClass('hide-border-top');
					}
				)
				// .addIndicators()
				.addTo(controller);
				website.scrollMagicScenes.push(scene);
			}
		);

		selectors = '.block-text-2-columns .text, .block-text-2-columns .links';
		selectors += ', .slider-3x-module .slider-3x, .slider-3x-module .slider-outer-wrapper';
		elements = $(selectors);
		$(elements).each(
			function () {
				var el = this;
				var offset = 100; // 200

				if($(window).width() < 768){
					offset = -50;
				}

				var scene = new ScrollMagic.Scene({
					'triggerElement': el,
					'offset': offset,
					'triggerHook': 1
				})
				.on('enter',
					function (event) {
						$(el).addClass('show')
					}
				)
				// .addIndicators()
				.addTo(controller);
				website.scrollMagicScenes.push(scene);
			}
		);
		*/
	},

	setHeader: function () {
		var scroll_top = $(window).scrollTop();
		if (scroll_top > website.small_header_limit) {
			if (!$(website.body).hasClass('small-header')) {
				$(website.body).addClass('small-header');
			}
		} else {
			if ($(website.body).hasClass('small-header')) {
				$(website.body).removeClass('small-header');
			}
		}
	},

	initCalendarTooltips: function(){
		$('.block-calender .tooltip:not(.initialized) video').each(
			function(){
				var video = this;
				var tooltip = $(video).parents('.tooltip').eq(0);
				var article = $(video).parents('.mec-event-article').eq(0);
				$(article).mouseenter(
					function(){
						$(video).get(0).play();
					}
				);
				$(article).mouseleave(
					function(){
						$(video).get(0).pause();
					}
				);
				$(tooltip).addClass('initialized');
			}
		);
	},

	initNewsOverview: function(){
		$('.block-news-overview .video:not(.initialized) video').each(
			function(){
				var video = this;
				var video_wrapper = $(video).parents('.video').eq(0);
				var article = $(video).parents('a').eq(0);
				$(article).mouseenter(
					function(){
						$(video_wrapper).addClass('video-started');
						$(video).get(0).play();
					}
				);
				$(article).mouseleave(
					function(){
						$(video).get(0).pause();
					}
				);
				$(video_wrapper).addClass('initialized');
			}
		);
	},

	setViewportScroll: function () {
		var scroll_top = $(window).scrollTop();
		if (scroll_top > $(window).height()) {
			if (!$(website.body).hasClass('viewport-scrolled')) {
				$(website.body).addClass('viewport-scrolled');
			}
		} else {
			if ($(website.body).hasClass('viewport-scrolled')) {
				$(website.body).removeClass('viewport-scrolled'); 
			}
		}

		if (scroll_top > $(window).height()/2) {
			if (!$(website.body).hasClass('half-viewport-scrolled')) {
				$(website.body).addClass('half-viewport-scrolled');
			}
		} else {
			if ($(website.body).hasClass('half-viewport-scrolled')) {
				$(website.body).removeClass('half-viewport-scrolled');
			}
		}
	},


	initNavigation: function () {
		var main_nav = $('header nav > ul').clone();
		var lang_nav = $('footer .lang-nav > ul').clone();
		var footer_nav = $('footer .footer-nav:not(.lang-nav) > ul').clone();
		var mobile_navigation = $('<div class="mobile-navigation"><div class="wrapper"><div class="container-fluid"><div class="row"><div class="col-12"><div class="lang-nav"></div><div class="main-nav"></div><div class="footer-nav"></div></div></div></div></div></div>');

		$(mobile_navigation).find('.lang-nav').append(lang_nav);
		$(mobile_navigation).find('.main-nav').append(main_nav);
		$(mobile_navigation).find('.footer-nav').append(footer_nav);

		$(website.body).append(mobile_navigation);

		$(website.body).append('<a class="burger"><span class="first"></span><span class="second"></span><span class="third"></span></a>');

		$('.burger').unbind('click').click(
			function () {
				$(website.body).toggleClass('show-navigation');
				return false;
			}
		);

	},

	initStage: function(){
		var window_height = $(window).height();
		// $('head').append('<style type="text/css">.block-stage .bg { height: '+window_height+'px; }</style>');
	},

	initFooter: function () {

	},

	initForms: function () {

	},

	initMasonries: function(){
		$('.grid-masonry').each(
			function(){
				var options = {
					'itemSelector': '.grid-item',
					'columnWidth': '.grid-sizer',
					'percentPosition': true
				};
				$(this).masonry(options);
			}
		);
	},

	initCarousels: function () {
		$('.owl-carousel').each(
			function () {
				var options = {
					'items': 1,
					'dots': true,
					'nav': false,
					'loop': true,
					'autoplay': true,
					'autoplayTimeout': 10000,
					'smartSpeed': 1500,
					'slideBy': 1,
					'mouseDrag': false,
					'touchDrag': false,
					'pullDrag': false
				};

				var carousel = this;

				/*
				if ($(carousel).hasClass('slider-3x')) {
					options = {
						'items': 1,
						'dots': true,
						'nav': false,
						'loop': true,
						'autoplay': false,
						'autoplayTimeout': 4500,
						'smartSpeed': 1500,
						'slideBy': 1,
						'mouseDrag': false,
						'touchDrag': false,
						'pullDrag': false
					};
				}
				*/

				if ($(carousel).find('.item').length > 1) {
					$(carousel).owlCarousel(options);
				}
			}
		);

	},

	initMoreText: function () {
		// selected in wysiwyg
		$('.more-text').each(
			function () {
				var html = '<a href="#" class="show-more-text-btn"><span class="more">'+website.translations.read_more+'</span></a>';
				$(this).after(html);
			}
		);
		// by divider
		$('.block-project-details hr').addClass('more-text');
		$('.block-project-details hr').nextAll().addClass('more-text');
		$('.block-project-details hr').each(
			function () {
				var html = '<a href="#" class="show-more-text-btn"><span class="more">'+website.translations.read_more+'</span></a>';
				$(this).before(html);
			}
		);
		$('.show-more-text-btn').unbind('click').click(
			function () {
				var div = $(this).parents('p, div').eq(0);
				$(div).toggleClass('show-more-text');
				return false;
			}
		);
	},

	initAccordion: function(){
		var acc = $('.accordion');

		$(acc).unbind('click').click(
			function(){
				var el = this;
				var wrapper = $(el).parents('.module').eq(0);

				$(el).addClass('new-active');

				// close already opened elements
				var active_elements = $(wrapper).find('.active:not(.new-active)');
				if($(active_elements).length > 0){
					$(active_elements).each(
						function(){
							var a = this;
							var p = $(a).next('.panel');
							$(a).removeClass('active');
							$(p).css('max-height', 0);
						}
					);
				}

				$(el).toggleClass('active');
				var panel = $(el).next('.panel');
				if ($(panel).css('max-height').replace('px', '') * 1 > 0) {
					$(panel).css('max-height', 0);
				} else {
					$(panel).css('max-height', $(panel).prop('scrollHeight'));
				}

				$(acc).removeClass('new-active');
			}
		);
	},

	scrollToYPosition: function (y) {
		$(website.body).removeClass('show-navigation');
		$('html, body').animate({
			scrollTop: y
		}, 1000, 'swing', function () {
			// do nothing
		});
	},

	scrollToElement: function (element) {
		var position = $(element).offset();
		var header = $('header');
		var y = position.top - $(header).outerHeight();
		website.scrollToYPosition(y);
	},

	scrollToArticle: function () {
		var anchor = this;
		var href = $(anchor).attr('href').split('#');
		var article = $('[data-href*="#' + href[1] + '"]').eq(0);
		if ($(article).length > 0) {
			website.scrollToElement(article);
			return false;
		}
		return true;
	},

	initOnepager: function () {
		$('a[href*="#/"]').click(website.scrollToArticle);
		if (window.location.hash != '') {
			var anchor = $('a[href$="' + window.location.hash + '"]').eq(0);
			if ($(anchor).length > 0) {
				setTimeout(
					function () {
						$(anchor).trigger('click');
					}, 1000
				);
			} else {
				if ($('[data-href="' + window.location.hash + '"]').length > 0) {
					website.scrollToElement($('[data-href="' + window.location.hash + '"]'));
				}
			}
		}
	},

	initWindowResizes: function () {
		$(website.scrollMagicScenes).each(
			function () {
				this.destroy(true);
			}
		);
		website.initFluffyAnimations();
	},

	initWindowScrolls: function () {
		website.setHeader();
		website.setViewportScroll();
	},

	isTouchDevice: function () {
		return 'ontouchstart' in window;
	}
}

$(document).ready(website.init);


//press release archive
$(".archiv-list .heading").click(function(){
    $(".archiv-list .heading").each(function(){
      $(this).parent().removeClass("active");
      $(this).removeClass("active");
    });
    $(this).parent().addClass("active");
    $(this).addClass("active");
});


//mobile-menu-popup
$("#menubtn").click(function(){
	$("#mobile-headermenu").addClass("active");
	$("body").addClass("active");
});

$(".mobile-archiv").click(function(){
	$("#archiv-popup").addClass("active");
	$("body").addClass("active");
});

$(".close-box").click(function(){
	$(".mobile-header-popup").removeClass("active");
	$("body").removeClass("active");
});

//heade fixed on scroll on mobile
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = 0;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}




