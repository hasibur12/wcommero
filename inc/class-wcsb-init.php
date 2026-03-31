<?php
/**
 * @package wcommero-store-builder
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WCSB_Init' ) ) {

	class WCSB_Init {

		// instance
		protected static $instance;

		public function __construct() {
			// plugin assets
			add_action( 'wp_enqueue_scripts', array( $this, 'plugin_assets' ), 10 );

			// load plugin dependency files
			$this->load_plugin_dependency_files();
		}

		/**
		 * plugin_assets()
		 * @since 1.0.0
		 */
		public function plugin_assets() {
			$this->load_plugin_css();
			$this->load_plugin_js();
		}

		/**
		 * Google fonts URL helper
		 */
		public static function wcsb_fonts_url() {
			$fonts_url    = '';
			$font_families = array();

			if ( 'off' !== esc_html_x( 'on', 'Google font: on or off', 'wcommero-store-builder' ) ) {
				$font_families[] = 'Montserrat:ital,wght@0,100..900;1,100..900&display=swap';
				$font_families[] = 'Roboto:ital,wght@0,100..900;1,100..900&display=swap';
				$query_args       = array(
					'family'  => urlencode( implode( '|', $font_families ) ),
					'display' => 'swap',
				);
				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );
			}

			return esc_url_raw( $fonts_url );
		}

		/**
		 * load plugin css
		 * @since 1.0.0
		 */
		public function load_plugin_css() {
			wp_enqueue_style( 'wcsb-font', self::wcsb_fonts_url(), array(), WCSB_VERSION, 'all' );
			wp_enqueue_style( 'wcsb-grid', WCSB_CSS . '/bootstrap-grid.css', array(), WCSB_VERSION, 'all' );
			wp_enqueue_style( 'wcsb-swiper', WCSB_CSS . '/swiper-bundle.min.css', array(), WCSB_VERSION, 'all' );
			wp_enqueue_style( 'wcsb-nice-select', WCSB_CSS . '/nice-select.css', array(), WCSB_VERSION, 'all' );
			wp_enqueue_style( 'wcsb-fontawesome', WCSB_CSS . '/all.min.css', array(), WCSB_VERSION, 'all' );
			wp_enqueue_style( 'wcsb-magnific', WCSB_CSS . '/magnific-popup.css', array(), WCSB_VERSION, 'all' );
		wp_enqueue_style( 'wcsb-main', WCSB_CSS . '/main.css', array(), WCSB_VERSION, 'all' );
		}

		/**
		 * load plugin js
		 * @since 1.0.0
		 */
		public function load_plugin_js() {
			wp_enqueue_script( 'wcsb-owl-carousel', WCSB_JS . '/owl.carousel.min.js', array( 'jquery' ), WCSB_VERSION, true );
			wp_enqueue_script( 'wcsb-imagesloaded', WCSB_JS . '/imagesloaded.pkgd.min.js', array( 'jquery' ), WCSB_VERSION, true );
			wp_enqueue_script( 'wcsb-magnific', WCSB_JS . '/magnific.min.js', array( 'jquery' ), WCSB_VERSION, true );
			wp_enqueue_script( 'wcsb-isotope', WCSB_JS . '/isotope.pkgd.min.js', array( 'jquery' ), WCSB_VERSION, true );
			wp_enqueue_script( 'wcsb-swiper', WCSB_JS . '/swiper-bundle.min.js', array( 'jquery' ), WCSB_VERSION, true );
			wp_enqueue_script( 'wcsb-main', WCSB_JS . '/swp-main.js', array( 'jquery' ), WCSB_VERSION, true );
			wp_enqueue_script( 'wcsb-elementor-script', WCSB_JS . '/elementor-script.js', array( 'jquery' ), WCSB_VERSION, true );
		}

		/**
		 * load_plugin_dependency_files()
		 * @since 1.0.0
		 */
		public function load_plugin_dependency_files() {
			if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
				require WCSB_ROOT_PATH . 'lib/tgma/activate.php';
			}

			$includes_files = array(
				array(
					'file-name' => 'wcsb-elementor-widgets-init',
					'file-path' => WCSB_ELEMENTOR,
				),
				array(
					'file-name' => 'functions',
					'file-path' => WCSB_INC,
				),
			);

			if ( is_array( $includes_files ) && ! empty( $includes_files ) ) {
				foreach ( $includes_files as $file ) {
					if ( file_exists( $file['file-path'] . '/' . $file['file-name'] . '.php' ) ) {
						require $file['file-path'] . '/' . $file['file-name'] . '.php';
					}
				}
			}
		}
	} // end class

	new WCSB_Init();
}
