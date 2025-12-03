function BlogKitTaxonomySliderInit(uniqueId) {
    var slider = document.getElementById('blogkit-taxonomy-slider-' + uniqueId);
    if (!slider) return;

    var slider_setting = JSON.parse(slider.getAttribute('data-swiper-settings'));

    new Swiper(slider, {
        loop: slider_setting.loop || false,
        grabCursor: true,

        // Autoplay
        autoplay: slider_setting.autoplay ? {
            delay: slider_setting.autoplay.delay,
            pauseOnMouseEnter: slider_setting.autoplay.pauseOnMouseEnter,
            disableOnInteraction: slider_setting.autoplay.disableOnInteraction
        } : false,

        // Navigation
        navigation: {
            nextEl: slider.getAttribute('data-next-el'),
            prevEl: slider.getAttribute('data-prev-el'),
        },
        // Pagination
          pagination: {
                el: '.blogkit-taxonomy-slider-pagination',
                clickable: true,
                dynamicBullets: true
            },

        // Breakpoints
        breakpoints: {
            0: {
                slidesPerView: slider_setting.slides_per_view_mobile,
                spaceBetween: slider_setting.space_between_mobile,
            },
            768: {
                slidesPerView: slider_setting.slides_per_view_tablet,
                spaceBetween: slider_setting.space_between_tablet,
            },
            1024: {
                slidesPerView: slider_setting.slides_per_view_desktop,
                spaceBetween: slider_setting.space_between_desktop,
            },
        }
    });

    console.log("Initialized BlogKit Taxonomy Slider:", uniqueId);
}


/* -----------------------------
   Elementor Frontend Integration
-------------------------------*/
jQuery(window).on('elementor/frontend/init', () => {
    elementorFrontend.hooks.addAction('frontend/element_ready/global', ($scope) => {

        var sliderElement = $scope.find('.blogkit-taxonomy-slider.swiper-container');

        if (sliderElement.length && sliderElement.attr('id')) {
            var uniqueId = sliderElement.attr('id').replace('blogkit-taxonomy-slider-', '');
            BlogKitTaxonomySliderInit(uniqueId);
        }
    });
});
