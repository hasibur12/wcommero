;(function ($) {
  "use strict";

  var WcommeroSlider = function ($scope) {

    if ($scope.find('.shop-slider').length > 0) {
      var $el = $scope.find(".shop-slider")[0];
      var data = $el.getAttribute('data-slider-settings');
      var opts = data ? JSON.parse(data) : {};
      var spaceBetween = typeof opts.margin !== 'undefined' ? opts.margin : 30;
      var speed = typeof opts.smart_speed !== 'undefined' ? opts.smart_speed : 700;
      var loop = typeof opts.loop !== 'undefined' ? opts.loop : true;
      var items = typeof opts.items !== 'undefined' ? opts.items : 3;
      var swiperOpts = {
          spaceBetween: spaceBetween,
          speed: speed,
          loop: loop,
          breakpoints: {
              1199: { slidesPerView: Math.min(4, items) },
              991: { slidesPerView: Math.min(3, items) },
              767: { slidesPerView: Math.min(2, items) },
              575: { slidesPerView: 1 },
              0: { slidesPerView: 1 },
          },
      };
      if (opts.loop) {
          swiperOpts.autoplay = {
              delay: 2000,
              disableOnInteraction: false,
          };
      }
      if (opts.enable_nav) {
          swiperOpts.navigation = {
              nextEl: $scope.find(".array-next")[0] || ".array-next",
              prevEl: $scope.find(".array-prev")[0] || ".array-prev",
          };
      }
      if (opts.enable_dots) {
          swiperOpts.pagination = {
              el: $scope.find(".dot")[0] || ".dot",
              clickable: true,
          };
      }
      new Swiper($el, swiperOpts);
    }

    if ($scope.find('.shop-slider2').length > 0) {
      var $el2 = $scope.find(".shop-slider2")[0];
      var data2 = $el2.getAttribute('data-slider-settings');
      var opts2 = data2 ? JSON.parse(data2) : {};
      var spaceBetween2 = typeof opts2.margin !== 'undefined' ? opts2.margin : 30;
      var speed2 = typeof opts2.smart_speed !== 'undefined' ? opts2.smart_speed : 700;
      var loop2 = typeof opts2.loop !== 'undefined' ? opts2.loop : true;
      var swiperOpts2 = {
        effect: "coverflow",
        spaceBetween: spaceBetween2,
        speed: speed2,
        centeredSlides: true,
        loop: loop2,
        coverflowEffect: {
            rotate: 30,
            stretch: 0,
            depth: 60,
            modifier: 1,
            slideShadows: false,
            scale: 1
        },
        breakpoints: {
            1399: { slidesPerView: 3, spaceBetween: Math.min(60, spaceBetween2 * 2) },
            1199: { slidesPerView: 3, spaceBetween: spaceBetween2 },
            991: { slidesPerView: 2, spaceBetween: spaceBetween2 },
            767: { slidesPerView: 2, spaceBetween: spaceBetween2 },
            575: { slidesPerView: 1, spaceBetween: spaceBetween2 },
            0: { slidesPerView: 1 },
        },
      };
      if (opts2.loop) {
          swiperOpts2.autoplay = {
              delay: 2000,
              disableOnInteraction: false,
          };
      }
      if (opts2.enable_nav) {
          swiperOpts2.navigation = {
              nextEl: $scope.find(".array-prev")[0] || ".array-prev",
              prevEl: $scope.find(".array-next")[0] || ".array-next",
          };
      }
      if (opts2.enable_dots) {
          swiperOpts2.pagination = {
              el: $scope.find(".dot")[0] || ".dot",
              clickable: true,
          };
      }
      new Swiper($el2, swiperOpts2);
    }
  };

  var WcommeroTab = function ($scope) {
     // Custom Tab
     if ($scope.find('.custom-tabs').length) {

      $scope.find('.custom-tabs').each(function () {

          const $tabWrap = $(this);
          const $tabBtn = $tabWrap.find('.tab-btn');
          const $tabContent = $tabWrap.find('.tab');

          $tabBtn.on('click', function () {

              const tab_id = $(this).data('tab');

              $tabBtn.removeClass('active');
              $(this).addClass('active');

              $tabContent.removeClass('active');
              $('#' + tab_id).addClass('active');

          });

      });

  }
}



  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/wcommero-slider.default",
      WcommeroSlider,
    );

    elementorFrontend.hooks.addAction(
      "frontend/element_ready/wcommero-tab.default",
      WcommeroTab,
    );
  });
})(jQuery);
