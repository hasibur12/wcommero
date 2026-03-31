=== WCommero – Store Builder for WooCommerce ===

Contributors: devhasib
Tags: elementor, woocommerce, products, grid, carousel
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Requires Plugins: woocommerce, elementor
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Display WooCommerce products beautifully with Elementor. Grid, Carousel, Tabs, List & more—fully customizable, responsive, and easy to use.

== Description ==

**WCommero – Store Builder for WooCommerce** brings powerful, flexible product display widgets to Elementor. Build stunning shop sections, featured product blocks, and product showcases without touching a line of code.

= Key Features =

* **Multiple Layout Styles** — Choose from Grid, Carousel/Slider, Isotope, Tabs, and List layouts
* **General Grid Widget** — Display products in responsive grids with 3 distinct card styles
* **Product Carousel** — Smooth, touch-friendly sliders for featured products and promotions
* **Tabbed Products** — Organize products by category in clean, space-saving tabs
* **List Layout** — Show products in compact list view for comparison or dense layouts
* **Fully Responsive** — All widgets adapt to mobile, tablet, and desktop
* **Elementor Native** — Full control via Elementor's live editor: columns, spacing, typography, and more

= Requirements =

* WordPress 5.0 or higher
* WooCommerce (active)
* Elementor 2.0 or higher

Perfect for landing pages, homepage product sections, category pages, and custom shop designs.

== Third-Party Libraries ==

This plugin includes the following third-party libraries. Their source code is available at the URLs listed below:

* **Swiper** (assets/js/swiper-bundle.min.js, assets/css/swiper-bundle.min.css)
  License: MIT — https://github.com/nolimits4web/swiper

* **Magnific Popup** (assets/js/magnific.min.js, assets/css/magnific-popup.css)
  License: MIT — https://github.com/dimsemenov/Magnific-Popup

* **Font Awesome Free** (assets/js/fontawesome.min.js, assets/css/all.min.css, assets/webfonts/)
  License: Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT — https://github.com/FortAwesome/Font-Awesome

* **Isotope** (assets/js/isotope.pkgd.min.js)
  License: GPL v3 — https://github.com/metafizzy/isotope

* **imagesLoaded** (assets/js/imagesloaded.pkgd.min.js)
  License: MIT — https://github.com/desandro/imagesloaded

* **TGM Plugin Activation** (lib/tgma/)
  License: GPL v2 — https://github.com/TGMPA/TGM-Plugin-Activation

== Source Code ==

The complete source code for this plugin, including build files and unminified assets, is publicly available at:
https://github.com/devhasib/wcommero-store-builder

== Installation ==

1. Upload the plugin to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. WooCommerce and Elementor must be installed and active.

== Changelog ==


= 1.0.4 =
* Fixed old text domain 'wcommero' in TGM library to match plugin slug 'wcommero-store-builder'.
* Updated Swiper from 8.3.2 to 11.2.6.
* Updated Font Awesome Free from 5.12.0 to 6.7.2.
* Updated source code URL to public GitHub repository.

= 1.0.3 =
* Renamed plugin to WCommero – Store Builder for WooCommerce.
* Updated plugin slug to wcommero-store-builder.
* Fixed text domain to match plugin slug.
* Fixed inline style output to use wp_add_inline_style().
* Fixed Elementor widget namespaces to avoid collision with Elementor core namespace.
* Added Requires Plugins header for WooCommerce and Elementor.
* Updated all internal prefix constants from WCOMMERCO_ to WCSB_.
* Documented all third-party libraries in readme.

= 1.0.0 =
* Initial release.
