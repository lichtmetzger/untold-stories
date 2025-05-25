jQuery(function( $ ) {
	'use strict';

	var $window = $(window);

	/* -----------------------------------------
	Responsive Menus Init with mmenu
	----------------------------------------- */
	var $mainNav = $('.site-bar .navigation');
	var $mobileNav = $( '#mobilemenu' );

	$mainNav.clone().removeAttr( 'id' ).removeClass().appendTo( $mobileNav );
	$mobileNav.find( 'li' ).removeAttr( 'id' );

	$mobileNav.mmenu({
		offCanvas: {
			position: 'top',
			zposition: 'front'
		},
		"autoHeight": true,
		"navbars": [
			{
				"position": "top",
				"content": [
					"prev",
					"title",
					"close"
				]
			}
		],
		"extensions": [
			"theme-black"
		]
	});

	/* -----------------------------------------
	Main Navigation Init
	----------------------------------------- */
	$mainNav.superfish({
		delay: 300,
		animation: { opacity: 'show', height: 'show' },
		speed: 'fast',
		dropShadows: false
	});

	/* -----------------------------------------
	Responsive Videos with fitVids
	----------------------------------------- */
	$( 'body' ).fitVids();


	/* -----------------------------------------
	Image Lightbox
	----------------------------------------- */
	$( ".untoldstories-lightbox, a[data-lightbox^='gal']" ).magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true
		},
		zoom: {
			enabled: true
		}
	} );


	/* -----------------------------------------
	Instagram Widget
	----------------------------------------- */
	var $instagramWrap = $('.footer-widget-area');
	var $instagramWidget = $instagramWrap.find('.instagram-pics');

	if ( $instagramWidget.length ) {
		var auto  = $instagramWrap.data('auto'),
				speed = $instagramWrap.data('speed');

		$instagramWidget.slick({
			slidesToShow: 8,
			slidesToScroll: 3,
			arrows: false,
			autoplay: auto == 1,
			speed: speed,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 4
					}
				}
			]
		});
	}


	/* -----------------------------------------
	Justfied Galleries
	----------------------------------------- */
	var $entryJustified = $('.entry-justified');
	if ( $entryJustified.length ) {
		$entryJustified.each(function() {
			var rowHeight = $(this).data('height');
			$(this).justifiedGallery({
				rowHeight : rowHeight,
				margins : 5,
				captions: false
			});
		})
	}


	/* -----------------------------------------
	Main Carousel
	----------------------------------------- */
	function positionSliderButtons() {
		var $currentSlide = $fullwidthSlider.find('.slick-current');
		$fullwidthSlider.find('.slick-prev').css({
			'right': $currentSlide.offset().left + 80
		});

		$fullwidthSlider.find('.slick-next').css({
			'right': $currentSlide.offset().left + 30
		});
	}

	var homeSlider = $( '.feature-slider'),
			$fullwidthSlider = $( '.slider-fullwidth' );

	if ( homeSlider.length ) {
		var autoplay = homeSlider.data( 'autoplay' ),
				autoplayspeed = homeSlider.data( 'autoplayspeed' ),
				fade = homeSlider.data( 'fade' );

		if ( homeSlider.hasClass( 'slider-fullwidth' ) ) {
			$fullwidthSlider.on('beforeChange', function(event, slick, currentSlide) {
				$(this).find('.slick-slide').eq(currentSlide+2).find('.slide-content').fadeOut();
			});

			$fullwidthSlider.on('afterChange', function(event, slick, currentSlide) {
				$(this).find('.slick-slide').eq(currentSlide+2).find('.slide-content').fadeIn('fast');
			});

			$fullwidthSlider.on('init', function(slick) {
				var $currentSlide = $fullwidthSlider.find('.slick-current');
				$currentSlide.find('.slide-content').fadeIn();
				positionSliderButtons();
			});

			$window.on('resize', function() {
				if ( $window.width() > 767 ) {
					positionSliderButtons();
				}
			});

			homeSlider.slick({
				autoplay: autoplay == 1,
				autoplaySpeed: autoplayspeed,
				centerMode: true,
				centerPadding: '30px',
				slidesToShow: 1,
				variableWidth: true,
				responsive: [
					{
						breakpoint: 1200,
						settings: {
							variableWidth: false
						}
					},
					{
						breakpoint: 768,
						settings: {
							centerMode: false,
							variableWidth: false,
							centerPadding: '5px'
						}
					}
				]
			});


		} else {
			homeSlider.slick({
				autoplay: autoplay == 1,
				autoplaySpeed: autoplayspeed,
				fade: fade == 1
			});
		}
	}

	/* -----------------------------------------
	 Single product lightbox trigger
	 ----------------------------------------- */
	$( '.woocommerce-product-gallery__trigger' ).html( '<i class="fa fa-search-plus"></i>' );

	$( window ).load(function() {

		/* -----------------------------------------
		Reveal Footer
		----------------------------------------- */
		var $footer = $('#footer');

		if ( $footer.hasClass('footer-fixed') ) {
			var $mainWrap = $('#main-wrap');
			var $footerHeight = $footer.outerHeight();
			$mainWrap.css('margin-bottom', $footerHeight);
		}

		/* -----------------------------------------
		Masonry Layout
		----------------------------------------- */
		var $masonry = $('.entries-masonry');
		if ( $masonry.length ) {
			$('.entries-masonry').masonry({
				itemSelector: '.entry-masonry'
			});
		}
	});

	/* -----------------------------------------
	Media Query Check
	----------------------------------------- */
	function ciResize() {
		var $entriesList = $('.entries-list');
		if ( $entriesList.length ) {
			if ( Modernizr.mq('only screen and (max-width: 768px)') ) {
				$('.entries-list .entry:not(:first)').each(function(){
					$(this).removeClass('entry-list');
				});
			}
			else {
				$('.entries-list .entry:not(:first)').each(function(){
					$(this).addClass('entry-list');
				});
			}
		}
	}

	$(window).resize(function() {
		ciResize();
	}).resize();

});
