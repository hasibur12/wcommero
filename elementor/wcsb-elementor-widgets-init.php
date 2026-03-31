<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main WCommero Store Builder Elementor Widgets Init Class
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'WCSB_Elementor_Widgets_Init' ) ) {

	final class WCSB_Elementor_Widgets_Init {

		const VERSION                   = '1.0.3';
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
		const MINIMUM_PHP_VERSION       = '7.4';

		private static $_instance = null;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}

		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
				return;
			}

			add_action( 'elementor/elements/categories_registered', array( $this, 'wcsb_widget_categories' ) );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'wcsb_widget_registered' ) );
		}

		public function admin_notice_missing_main_plugin() {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display-only admin notice, no action.
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wcommero-store-builder' ),
				'<strong>' . esc_html__( 'WCommero Store Builder', 'wcommero-store-builder' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'wcommero-store-builder' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
		}

		public function admin_notice_minimum_elementor_version() {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display-only admin notice, no action.
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wcommero-store-builder' ),
				'<strong>' . esc_html__( 'WCommero Store Builder', 'wcommero-store-builder' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'wcommero-store-builder' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
		}

		public function admin_notice_minimum_php_version() {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display-only admin notice, no action.
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wcommero-store-builder' ),
				'<strong>' . esc_html__( 'WCommero Store Builder', 'wcommero-store-builder' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'wcommero-store-builder' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
		}

		public function wcsb_widget_categories( $elements_manager ) {
			$elements_manager->add_category(
				'wcsb-widgets',
				array(
					'title' => esc_html__( 'WCommero Store Builder', 'wcommero-store-builder' ),
					'icon'  => 'fa fa-plug',
				)
			);
		}

		public function wcsb_widget_registered() {
			if ( ! class_exists( 'Elementor\Widget_Base' ) ) {
				return;
			}

			$elementor_widgets = array(
				'general',
				'slider',
				'tab',
				'list',
			);
			$elementor_widgets = apply_filters( 'wcsb_elementor_widgets', $elementor_widgets );

			if ( is_array( $elementor_widgets ) && ! empty( $elementor_widgets ) ) {
				foreach ( $elementor_widgets as $widget ) {
					$template_file = WCSB_ELEMENTOR . '/widgets/class-wcommero-style-' . $widget . '.php';
					if ( $template_file && is_readable( $template_file ) ) {
						include_once $template_file;
					}
				}
			}
		}
	}

	WCSB_Elementor_Widgets_Init::instance();
}
