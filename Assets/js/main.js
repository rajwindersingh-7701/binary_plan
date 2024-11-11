(function($){
    "use strict";
    jQuery(document).on('ready', function(){
        // Header Sticky
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 150){  
                $('.header-sticky').addClass("is-sticky");
            }
            else{
                $('.header-sticky').removeClass("is-sticky");
            }
        });

        // Hero Slider
        $('.hero-slider').owlCarousel({
            items: 1,
            thumbs: true,
            dots: true,
            touchDrag: true,
            mouseDrag: false,
            smartSpeed: 1000,
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            nav: true,
            navText: [
                "<i class='icofont-rounded-left'></i>",
                "<i class='icofont-rounded-right'></i>"
            ]
        });

        $(".hero-slider").on("translate.owl.carousel", function(){
            $(".hero-item .welcome, .hero-item h2, .hero-item p").removeClass("animated fadeInUp").css("opacity", "0");
            $(".hero-item ul, .hero-item .price, .hero-item .hero-btn").removeClass("animated fadeInDown").css("opacity", "0");
        });
        
        $(".hero-slider").on("translated.owl.carousel", function(){
            $(".hero-item .welcome, .hero-item h2, .hero-item p").addClass("animated fadeInUp").css("opacity", "1");
            $(".hero-item ul, .hero-item .price, .hero-item .hero-btn").addClass("animated fadeInDown").css("opacity", "1");
        });

        // Property Slides
        $('.property-slider').owlCarousel({
            items:1,
            loop: true,
            autoplay: true,
            nav: true,
            smartSpeed: 1500,
            mouseDrag: true,
            autoplayHoverPause: true,
            responsiveClass: true,
            dots: false,  
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            navText: ["<i class='flaticon-left-arrow-key'></i>", "<i class='flaticon-keyboard-right-arrow-button'></i>"],         
        });

        // WOW 
        new WOW().init();

        // Video Popup
		$('.popup-youtube').magnificPopup({
			disableOn: 320,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
        });
        
        // Popup Gallery
		$('.popup-btn').magnificPopup({
            type: 'image',
            gallery:{
                enabled:true
            }
        });

        // MixItUp JS
        $('#Container').mixItUp();

        // Testimonial Slides
        $('.testimonials-slider').owlCarousel({
            loop: true,
            autoplay: false,
            nav: true,
            center: true,
            margin: 30,
            smartSpeed: 1000,
            mouseDrag: true,
            autoplayHoverPause: true,
            responsiveClass: true,
            dots: false,  
            navText: ["<i class='flaticon-left-arrow-key'></i>", "<i class='flaticon-keyboard-right-arrow-button'></i>"],         
            responsive:{
                0:{
                    items:1,
                },
                768:{
                    items:2,
                },
                1200:{
                    items:3,
                }
            }
        });

        // Partner Slider
        $('.partner-slider').owlCarousel({
            loop: true,
            autoplay:true,
            nav: false,
            mouseDrag: true,
            autoplayHoverPause: true,
            responsiveClass: true,
            dots: false,
            margin: 30,
            responsive:{
                0:{
                    items:3,
                },
                768:{
                    items:5,
                },
                1200:{
                    items:5,
                }
            }
        });

        // Amentities-slider
        $('.amentities-slider').owlCarousel({
            items:1,
            loop:true,
            autoplay:true,
            nav:true,
            responsiveClass:true,
            dots:false,
            autoplayHoverPause:true,
            mouseDrag:true,
            navText: [
            "<i class='flaticon-left-arrow-key'></i>",
            "<i class='flaticon-keyboard-right-arrow-button'></i>"
            ],
        });

        // Description Slides
        $('.description-slider').owlCarousel({
            loop: true,
            autoplay: true,
            nav: true,
            margin: 30,
            mouseDrag: true,
            autoplayHoverPause: true,
            responsiveClass: true,
            dots: true,  
            navText: [
            "<i class='flaticon-left-arrow-key'></i>",
            "<i class='flaticon-keyboard-right-arrow-button'></i>"
            ],       
            responsive:{
                0:{
                    items:1,
                },
                768:{
                    items:2,
                },
                1200:{
                    items:3,
                }
            }
        });

        // Client-slider
        $('.client-slider').owlCarousel({
            loop: true,
            autoplay: true,
            nav: false,
            margin: 30,
            mouseDrag: true,
            autoplayHoverPause: true,
            responsiveClass: true,
            dots: true,          
            responsive:{
                0:{
                    items:1,
                },
                768:{
                    items:1,
                },
                1200:{
                    items:1,
                }
            }
        });
 
        // TOP BUTTON JS CODE
		$('body').append('<div id="toTop" class="top-arrow"><i class="flaticon-select"></i></div>');
		$(window).on('scroll', function () {
			if ($(this).scrollTop() != 0) {
				$('#toTop').fadeIn();
			} else {
			$('#toTop').fadeOut();
			}
		}); 
		$('#toTop').on('click', function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
        // END TOP BUTTON JS CODE

        // Preloader Area
        jQuery(window).on('load', function() {
            $('.preloader').fadeOut();
        });

        // Subscribe form
		$(".newsletter-form").validator().on("submit", function (event) {
			if (event.isDefaultPrevented()) {
			// handle the invalid form...
				formErrorSub();
				submitMSGSub(false, "Please enter your email correctly.");
			} else {
				// everything looks good!
				event.preventDefault();
			}
		});
		function callbackFunction (resp) {
			if (resp.result === "success") {
				formSuccessSub();
			}
			else {
				formErrorSub();
			}
		}
		function formSuccessSub(){
			$(".newsletter-form")[0].reset();
			submitMSGSub(true, "Thank you for subscribing!");
			setTimeout(function() {
				$("#validator-newsletter").addClass('hide');
			}, 4000)
		}
		function formErrorSub(){
			$(".newsletter-form").addClass("animated shake");
			setTimeout(function() {
				$(".newsletter-form").removeClass("animated shake");
			}, 1000)
		}
		function submitMSGSub(valid, msg){
			if(valid){
				var msgClasses = "validation-success";
			} else {
				var msgClasses = "validation-danger";
			}
			$("#validator-newsletter").removeClass().addClass(msgClasses).text(msg);
		}
		// AJAX MailChimp
		$(".newsletter-form").ajaxChimp({
			url: "https://envytheme.us20.list-manage.com/subscribe/post?u=60e1ffe2e8a68ce1204cd39a5&amp;id=42d6d188d9", // Your url MailChimp
			callback: callbackFunction
        });
        
        // Tabs
        (function ($) {
            $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
            $('.tab ul.tabs li a').on('click', function (g) {
                var tab = $(this).closest('.tab'), 
                index = $(this).closest('li').index();
                tab.find('ul.tabs > li').removeClass('current');
                $(this).closest('li').addClass('current');
                tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
                tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
                g.preventDefault();
            });
		})(jQuery);
        
        // Tabs Two
        (function ($) {
            $('.tab ul.tabs-work').addClass('active').find('> li:eq(0)').addClass('current');
            $('.tab ul.tabs-work li a').on('click', function (g) {
                var tab = $(this).closest('.tab'), 
                index = $(this).closest('li').index();
                tab.find('ul.tabs-work > li').removeClass('current');
                $(this).closest('li').addClass('current');
                tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
                tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
                g.preventDefault();
            });
        })(jQuery);
	});
}(jQuery));