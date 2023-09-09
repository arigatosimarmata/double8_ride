$( document ).ready(function($) {
	$( '#slideshow' ).sliderPro({
		fade: true,
		arrows: true,
		buttons: false,
		fullScreen: true,
		autoplay: true,
		shuffle: false,
		smallSize: 500,
		mediumSize: 1000,
		largeSize: 3000,
		thumbnailArrows: true,
		breakpoints: {
			1920: {
				height:770,
				thumbnailWidth: 322,
				thumbnailHeight: 180
			},
			1590: {
				height:655,
				thumbnailWidth: 275,
				thumbnailHeight: 140
			},
			1349: {
				height:519,
				thumbnailWidth: 226.5,
				thumbnailHeight: 140
			},
			1366: {
				height:536,
				thumbnailWidth: 226.5,
				thumbnailHeight: 140
			},
			991: {
				height:425,
				thumbnailWidth: 100,
				thumbnailHeight: 80
			}
		}
	});

	$( '#slideshow-news' ).sliderPro({
		fade: true,
		arrows: true,
		buttons: false,
		autoplay: false,
		shuffle: false,
		thumbnailArrows: true,
		breakpoints: {
			1920: {
				height:470,
				thumbnailWidth: 320,
				thumbnailHeight: 150

			},
			1583: {
				height:450,
				thumbnailWidth: 275,
				thumbnailHeight: 140
			},
			1366: {
				height:420,
				thumbnailWidth: 226,
				thumbnailHeight: 100
			},
			991: {
				height:398,
				thumbnailWidth: 180,
				thumbnailHeight: 80
			}
		}
	});

	
	$(document).on('click', '#home', function() {
		$('body,html').animate({ scrollTop: $('#section-home').offset().top}, 1000);
	});

	$('#about').click(function() {
		$('body,html').animate({ scrollTop: $('#section-about').offset().top}, 1000);
	});

	$('#video').click(function() {
		$('body,html').animate({ scrollTop: $('#section-video').offset().top}, 1000);
	});

	$('#product').click(function() {
		$('body,html').animate({ scrollTop: $('#section-product').offset().top}, 1000);
	});

	$('#brands').click(function() {
		$('body,html').animate({ scrollTop: $('#section-brand').offset().top}, 1000);
	});

	$('#news').click(function() {
		$('body,html').animate({ scrollTop: $('#section-news').offset().top}, 1000);
	});

	$('#catalog').click(function() {
		$('body,html').animate({ scrollTop: $('#section-catalog').offset().top}, 1000);
	});

	$('#contact').click(function() {
		$('body,html').animate({ scrollTop: $('#section-contact').offset().top}, 1000);
	});

	$(".open-search").click(function () {
		$("#form-search").stop().slideToggle(200);
		$("#form-search").css('z-index','999');
		$("i", this).toggleClass("fa-search fa-times");
	});


// Function Click Toggle Menu
if($(window).width() < 991) { 
	$('.dropdown').click(function(){
		if($(this).hasClass('active')){
			$(this).find('.dropdown-content').stop().slideUp();
			$(this).removeClass('active');
			$(this).find('.nav-open-icon').removeClass('active');
		}else{
			$(this).find('.dropdown-content').stop().slideDown();
			$(this).addClass('active');
			$(this).find('.nav-open-icon').addClass('active');
		}
	});

	$('.footer-collapse').click(function(){
		if($(this).hasClass('active')){
			$(this).find('.footer-list-menu').stop().slideUp();
			$(this).removeClass('active');
			$(this).find('.footer-open-icon').removeClass('active');
		}else{
			$(this).find('.footer-list-menu').stop().slideDown();
			$(this).addClass('active');
			$(this).find('.footer-open-icon').addClass('active');
		}
	});

	$('.filter-collapse-parent').click(function(){
		if($(this).hasClass('active')){
			$(this).find('.filter-parent-list-menu').stop().slideUp();
			$(this).removeClass('active');
			$(this).find('.filter-open-icon').removeClass('active');
		}else{
			$(this).find('.filter-parent-list-menu').stop().slideDown();
			$(this).addClass('active');
			$(this).find('.filter-open-icon').addClass('active');
		}
	});

	// FILTER-CHILD-OPEN-ICON DROPDOWN
	$('.filter-collapse-child').click(function(){
		if($(this).hasClass('active')){
			$(this).find('.filter-child-list-menu').stop().slideUp();
			$(this).removeClass('active');
			$(this).find('.filter-child-open-icon').removeClass('active');
			return false;
		}else{
			$(this).find('.filter-child-list-menu').stop().slideDown();
			$(this).addClass('active');
			$(this).find('.filter-child-open-icon').addClass('active');
			return false;
		}
	});

	var show  = 0;
	$('#toggle-menu').click(function(){
		var parent	= $(this);
		$('#nav-toggle-open').animate({left:show},500, function () {
			if(show == 0){
				show = '-110%';
                	// parent.css('position','fixed');
                }else{
                    //alert('b');
                    show = 0;
                	// parent.css('top',138);
					// parent.css('position','absolute');
                	// parent.css('position','absolute');
                }
            });
		$('.nav-toggle', $(this)).toggleClass('active');
	});
};

// Scrollbar function
if($(window).width() > 991){
	$(document).ready(function(){
		$("body").addClass("thin");

		$("body").mouseover(function(){
			$(this).removeClass("thin");
		});
		$("body").mouseout(function(){
			$(this).addClass("thin");
		});
		$("body").scroll(function () {
			$("body").addClass("thin");
		});
	});
}

$(document).on('click','.img-thumb',function(){
	a = $(this).attr('href');
	b = $(this).data('zoom');
	$('.img-product-large > img').fadeOut(function(){
		var stage = "<img src='"+a+"' class='img-responsive image-zoom' data-zoom-image='"+b+"'/>";
		$('.img-product-large').html(stage);
		$('.zoomContainer').remove();
		$(".image-zoom").elevateZoom({
			constrainType:"height", constrainSize:450, zoomType: "lens", containLensZoom: true, gallery:'gallery_01', cursor: 'pointer', galleryActiveClass: "active"
		});
		$(this).fadeIn();
	});
	return false;
});

// Product Thumbnail Carousel
$('#product-list').slick({
	infinite: true,
	speed: 500,
	accessibility:false,
	arrows:false,
	slidesToShow: 5,
	slidesToScroll: 1,
	responsive: [
	{
		breakpoint: 1000,
		settings: {
			slidesToShow: 3,
			slidesToScroll: 2
		}
	},{
		breakpoint: 600,
		settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
	},{
		breakpoint: 500,
		settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
	}
	]
});
$(document).on('click','.product-prev-button',function(){
	$("#product-list").slick('slickPrev');
});
$(document).on('click','.product-next-button',function(){
	$("#product-list").slick('slickNext');
});

$('#brand-carousel').slick({
	infinite: true,
	speed: 500,
	accessibility:false,
	arrows:false,
	slidesToShow: 4,
	vertical: true,
	slidesToScroll: 1,
	responsive: [
	{
		breakpoint: 991,
		settings: {
			vertical: false,
			slidesToShow: 4,
			slidesToScroll: 2
		}
	}
	]
});
$(document).on('click','.brand-next-btn',function(){
	$("#brand-carousel").slick('slickNext');
});

$('#brand-content-carousel').slick({
	infinite: true,
	speed: 500,
	accessibility:false,
	arrows:false,
	slidesToShow: 1,
	slidesToScroll: 1
});
$(document).on('click','.brand-content-prev',function(){
	$("#brand-content-carousel").slick('slickPrev');
});
$(document).on('click','.brand-content-next',function(){
	$("#brand-content-carousel").slick('slickNext');
});


$('#catalog-list-carousel').slick({
	infinite: true,
	speed: 500,
	accessibility:false,
	arrows:false,
	slidesToShow: 6,
	slidesToScroll: 1,
	responsive: [
	{
		breakpoint:991,
		settings: {
			slidesToShow: 4,
			slidesToScroll:1
		}
	}
	]
});

$('#instagram-carousel').slick({
	rows: 2,
	infinite: true,
	speed: 500,
	accessibility:false,
	arrows:false,
	slidesToShow: 3,
	slidesToScroll: 1,
	responsive: [
	{
		breakpoint: 1000,
		settings: {
			slidesToShow: 3,
			slidesToScroll: 2
		}
	},{
		breakpoint: 600,
		settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
	},{
		breakpoint: 500,
		settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
	}
	]
});


$(document).on('click', '#showCatalog', function(){ 
	$('.show-dropdown-menu').stop().slideToggle(400);
});

$(document).on('click', '#showPrivacyMenu', function(){ 
	$('.show-dropdown-menu').stop().slideToggle(400);
});

//Check to see if the window is top if not then display button
$(window).scroll(function(){
	if ($(this).scrollTop() > 450) {
		$('.scrollToTop').fadeIn();
	} else {
		$('.scrollToTop').fadeOut();
	}
});

	//Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});

});