(function($){

    $(window).on('load', function() {
        typing();
        verifyInput();
        imageGallery();
    });

    // Placeholder Typewriter Effect Event
    function typing(){
        let selectItem = document.querySelector('.js--search');
        let searchPlaceholder = 'Search for Products...';
        let placeholder = '';
        let x = 0;
        selectItem.setAttribute('placeholder', '');
        let interval = setInterval(()=>{
            placeholder += searchPlaceholder[x];
            x++;
            selectItem.setAttribute('placeholder', placeholder);
            if(x > searchPlaceholder.length -1){
                clearInterval(interval);
                setTimeout(typing, 500);
            }
        }, 150);
    }

    // Header Sticky Event
    $(window).on('scroll', function() {
            var scroll=$(window).scrollTop(); 
            if(scroll>=80) {
                $(".header-bottom").addClass("sticky");
                $(".scrollTop").fadeIn("100");
            }

            else {
                $(".header-bottom").removeClass("sticky");
                $(".scrollTop").fadeOut("100");
            }
        }
    );

    // Scroll Top
    $(".scrollTop").click(function(){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });

    // Main Slider Initialize
    $(".main-slider, .category-page-slider").owlCarousel({
    	items: 1,
    	autoplay: true,
    	autoplayTimeout: 5000,
    	smartSpeed: 1000,
    	loop: true,
    	margin: 0,
    	nav: false,
    	dots: true,
    });

    // Clients Carousel Initialize
    $(".client-carousel").owlCarousel({
        items: 6,
        autoplay: true,
        autoplayTimeout: 3000,
        smartSpeed: 500,
        loop: true,
        margin: 5,
        nav: false,
        dots: false,
    });

    // Info Carousel Initialize
    $(".info-carousel").owlCarousel({
        loop: true,
        autoPlay: true,
        autoPlayTimeout: 1000,
        nav: false,
        dots: true,
        animateOut: 'slideOutDown',
        animateIn: 'flipInX',
        margin: 15,
        smartSpeed: 450,
        responsive: {
            0 : {
                items: 1,
            },
            768 : {
                items: 2,
            }
        },
    });

	// Countdown Initialize
	let fixTime = $('.countdown').attr('data-time');
	$('.countdown').countdown(fixTime, function(event) {
		$(this).html(event.strftime('<span>%d</span>:<span>%H</span>:<span>%M</span>:<span>%S</span>'));
	});

    // Mobile Search Event
    $(".mobile-search-trigger").click(function(){
        $(".inner-header-bottom .search-area").addClass("show");
        $(".overlay").fadeIn("100");
        $(".header-bottom.sticky").addClass("increase-index");
        return false;
    });
    $(".close-search").click(function(){
        $(".inner-header-bottom .search-area").removeClass("show");
        $(".overlay").fadeOut("100");
        $(".header-bottom.sticky").removeClass("increase-index");
        return false;
    });

    // Mobile Menu Event
    $(".mobile-menu-trigger").click(function(){
        $(".category-area").addClass("show");
        $(".overlay").fadeIn("100");
        return false;
    });
    $(".close-menu").click(function(){
        $(".overlay").fadeOut("100")
        $(".category-area").removeClass("show");
        return false;
    });

    // Mobile Sidebar Events
    $(".sidebar-toggler").click(function(){
        $(".sidebar-products-area .sidebar-area").addClass("show");
        $(".overlay").fadeIn("100")
        $(".sidebar-toggler").addClass("active");
        return false;
    });

    // Close Events
    $(".overlay").click(function(){
        $(".inner-header-bottom .search-area").removeClass("show");
        $(".overlay").fadeOut("100")
        $(".category-area").removeClass("show");
        $(".header-bottom.sticky").removeClass("increase-index");
        $(".sidebar-products-area .sidebar-area").removeClass("show");
        $(".sidebar-toggler").removeClass("active");
        $(".mobile-privacy-nav").removeClass("show");
        $(".mobile-nav").removeClass("show");
        $(".mobile-cart").removeClass("show");
    });

    // Filter Reviews
    let allReviews = document.querySelectorAll('.single-review');
    let filterBtn = document.querySelector('.filter-btn');
    if(filterBtn){
        filterBtn.addEventListener('click', function (){
            allReviews.forEach(function(single){
                console.log(single);
                if (!single.classList.contains('with-photo')){
                    single.classList.toggle('hide');
                }
            });
            this.classList.toggle('active');
        });
    }

    // Toggle Active 
    let helpfulBtn = document.querySelectorAll('.helpful-btn');
    if(helpfulBtn){
        helpfulBtn.forEach(function(singleBtn){
            singleBtn.addEventListener('click', function (){
                let getSpan = singleBtn.querySelector('span');
                getSpan.classList.toggle('material-icons-round');
            });
        });
    }

    // Manage Quantity Events
    let plusBtn = document.querySelectorAll(".qty-plus");
    let minusBtn = document.querySelectorAll(".qty-minus");
    console.log(minusBtn);
    if(plusBtn){
        plusBtn.forEach((single)=>{
            single.addEventListener('click', ()=>{
                let getInput = single.closest(".quantity-wrapper").querySelector('.input-wrapper input').value;
                getInput ++;
                single.closest(".quantity-wrapper").querySelector('.input-wrapper input').value = getInput;
            });
        });
    }
    if(minusBtn){
        minusBtn.forEach((single)=>{
            single.addEventListener('click', ()=>{
                let getInput = single.closest(".quantity-wrapper").querySelector('.input-wrapper input').value;
                getInput --;
                if(getInput == 0){
                    getInput = 1
                }
                single.closest(".quantity-wrapper").querySelector('.input-wrapper input').value = getInput;
            });
        });
    }
    
    //initiate the plugin and pass the id of the div containing gallery images
    $('#zoomImg').ezPlus({   
        responsive: true,
        scrollZoom: false,
        imageCrossfade: true,
        easing: true,
        borderSize: 0,
        zoomLens: false,
        zoomType: 'inner',
        gallery: 'image-gallery',
        cursor: 'pointer',
        galleryActiveClass: 'active',
    });

    $(".colors-wrapper li").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
    });

    // Input Verify Code Events
    function verifyInput(){
          let body = $('.verify-codes');

          function goToNextInput(e) {
            var key = e.which,
              t = $(e.target),
              sib = t.next('input');

            if (key != 9 && (key < 48 || key > 57)) {
              e.preventDefault();
              return false;
            }

            if (key === 9) {
              return true;
            }

            if (!sib || !sib.length) {
              sib = body.find('input').eq(0);
            }
            sib.select().focus();
          }

          function onKeyDown(e) {
            var key = e.which;

            if (key === 9 || (key >= 48 && key <= 57)) {
              return true;
            }

            e.preventDefault();
            return false;
          }
          
          function onFocus(e) {
            $(e.target).select();
          }

          body.on('keyup', 'input', goToNextInput);
          body.on('keydown', 'input', onKeyDown);
          body.on('click', 'input', onFocus);
    }

    // Initialize Image Gallery Carousel
    function imageGallery(){
        var swiper = new Swiper("#image-gallery", {
            effect: 'slide',
            pagination: false,
            slidesPerView: 'auto',
            spaceBetween: 5,
            autoHeight: true,
            navigation: {
              nextEl: ".button-next",
              prevEl: ".button-prev",
            },
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                0: {
                    direction: "horizontal",
                    slideToClickedSlide: true,
                    centeredSlides: true,
                    centerInsufficientSlides: true,
                    centeredSlidesBounds: true,
                },
                // when window width is >= 640px
                992: {
                    direction: "horizontal",
                }
            }
        });
    }

    // Toaster Close Event
    let toastClose = document.querySelector('.close-toast');
    if(toastClose){
        toastClose.addEventListener('click', ()=>{
            toastClose.closest('.mini-toast').style.display = 'none';
        });
    }

    // Handle Exerp Menu
    let viewMoreBtn = document.querySelectorAll('.viewmore-btn');
    for(let i=0; i < viewMoreBtn.length; i++){
        viewMoreBtn[i].addEventListener('click', (e)=>{
            let findParent = e.target.closest('.exerp-menu');
            if(findParent){
                findParent.querySelector('ul').classList.add('show-all');
            }
            e.target.closest('a').style.display = 'none';
            e.preventDefault();
        });
    }

    // Change Zoom Src
    let clickedImg = document.querySelectorAll('.product-media-area .product-photos ul li img');
    clickedImg.forEach((single)=>{
        single.addEventListener('click', (e)=>{
            let getSrc = e.target.getAttribute('src');
            document.querySelector('#zoom-trigger').setAttribute('href', getSrc);
        });
    });

    // Image Zoom
    $('.popup-image').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom',
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300
        }
    });

    // Review Popup Event
    let reviewTrigger = document.querySelector('#add-review-btn');
    let closePopup = document.querySelector('.add-review-popup .close-popup');
    let popupSelector = document.querySelector('#add-review-popup');
    if(reviewTrigger){
        reviewTrigger.addEventListener('click',(e)=>{
            popupSelector.classList.add('show');
        });
    }
    if(closePopup){
        closePopup.addEventListener('click', ()=>{
            popupSelector.classList.remove('show');
        });
    }

    // Control Review Stars    
    $(".add-review-popup .review-stars i.bi-star").click(function(){
        $(this).addClass("bi-star-fill").removeClass("bi-star");
        $(this).prevAll().addClass("bi-star-fill").removeClass("bi-star");
        $(this).nextAll().removeClass("bi-star-fill").addClass("bi-star");
    });

    // Size Chart Events
    $("#size-chart").click(function(){
        $("#chart-popup").fadeIn('100');
        return false;
    });
    $(".close-chart").click(function(){
        $("#chart-popup").fadeOut('100');        
    });

    // Expand Dashboard Sidebar
    $(".expand-trigger").click(function(){
        $(".sidebar-main-wrapper .sidebar-area").toggleClass("expand");
        $(".sidebar-main-wrapper .main-area").toggleClass("move-right");
    });

    // Language Switch
    $(".switch a").click(function(){
        let getIcon = $(this).find("i").html();
        if(getIcon == 'toggle_off'){
            $(this).find("i").html("toggle_on");
        }
        else{
            $(this).find("i").html("toggle_off");
        } 
        return false;       
    });

    // Mobile Privacy Nav 
    $(".privacy-trigger").click(function(){
        $(".mobile-privacy-nav").addClass("show");
        $(".overlay").fadeIn("100");
        return false;
    });

    // Fix Mobile Nav
    let checkSub = $(".checknav ul li").has("ul").addClass("has-sub");
    let clickElement = checkSub.find("> a");
    clickElement.click(function(){
        $(this).closest("li").find("> ul").slideToggle("100");
        $(this).closest("li").toggleClass("active");
        return false;
    });
    $(".mobile-nav-trigger").click(function(){
        $(".mobile-nav").addClass("show");
        $(".overlay").fadeIn("100");
        return false;
    });
    $(".close-nav").click(function(){
        $(".mobile-nav").removeClass("show");
        $(".overlay").fadeOut("100");
        $(".mobile-privacy-nav").removeClass("show");
        return false;
    });

    // Mobile Cart Events
    if ($(window).width() < 1025){
        $(".cart-trigger").click(function(){
            $(".mobile-cart").addClass("show");
            $(".overlay").fadeIn("100");
            return false;
        });        
    }
    $(".close-cart").click(function(){
        $(".mobile-cart").removeClass("show");
        $(".overlay").fadeOut("100");
        return false;
    });

    // Shipping Address Events
    $(".address-trigger").click(function(){
        $(".toggle-form").slideToggle("100");
        return false;
    });

}(jQuery));