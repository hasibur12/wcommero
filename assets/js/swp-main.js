(function ($) {
  "use strict";

  $(document).ready(function () {
    if ($(".swp-isotope").length) {
      var filterArea = $(".swp-isotope-area");

      filterArea.each(function () {
        var filterAreaId = $(this).data("filter-section");

        var Self = $(this);

        Self.find(".swp-isotope").addClass(filterAreaId);

        var $galleryFilterArea = $("." + filterAreaId);

        //button
        Self.find(".isotope-filters").addClass("swp" + filterAreaId);

        var $galleryFilterMenu = $(".swp" + filterAreaId);

        /*Filter*/
        $galleryFilterMenu.on("click", "button, a", function () {
          var $this = $(this),
            $filterValue = $this.attr("data-filter");
          $galleryFilterMenu.find("button, a").removeClass("active");
          $this.addClass("active");
          $galleryFilterArea.isotope({ filter: $filterValue });
        });
        /*Grid*/
        $galleryFilterArea.each(function () {
          var $this = $(this),
            $galleryFilterItem = ".swp-item";
          $this.imagesLoaded(function () {
            $this.isotope({
              itemSelector: $galleryFilterItem,
              percentPosition: true,
              masonry: {
                columnWidth: ".swp-sizer",
              },
            });
          });
        });
      });
    }
  });

  // Image popup - delegated for both static and Elementor-rendered content
  $(document).on("click", ".wco-image-popup, .swp-image-popup", function (e) {
    e.preventDefault();
    var src = $(this).attr("href");
    if (!src) return;
    $.magnificPopup.open({
      items: { src: src, type: "image" },
      type: "image",
      preloader: true,
      callbacks: {
        open: function () {
          var self = this;
          var img = new Image();
          img.onload = function () {
            self.updateStatus("ready");
          };
          img.onerror = function () {
            self.updateStatus("error");
          };
          img.src = src;
        },
      },
    });
  });

  $(document).on("added_to_cart", function (event, fragments, cart_hash) {
    $(".product").unblock();
    $("body").append(fragments["custom_message"]);
    setTimeout(function () {
      $("#custom-message").fadeOut("slow").remove();
    }, 3000); // Hide the message after 3 seconds
  });

  $(document).on("click", ".add_to_cart_button", function () {
    $(this)
      .closest(".product")
      .block({
        message: null,
        overlayCSS: {
          background: "#fff",
          opacity: 0.6,
        },
      });
  });
})(jQuery);
