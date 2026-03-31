<?php

namespace DevHasib\WCStoreBuilder\Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


/**
 *
 * wcommero elementor Contact widget.
 *
 * @since 1.0
 */
class Wcommero_General extends Widget_Base
{

    public function get_name()
    {
        return 'wcommero-general';
    }

    public function get_title()
    {
        return esc_html__('General Style', 'wcommero-store-builder');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['wcsb-widgets'];
    }

    protected function register_controls()
    {

        // general settings
        $this->start_controls_section(
            'wcommero_style_one_settings',
            [
                'label' => esc_html__('General Settings', 'wcommero-store-builder'),
            ]
        );


        $this->add_control(
            'style',
            [
                'label'   => esc_html__('Select Style', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT2,
                'options' => array(
                    'style-1' => esc_html__('Style 1', 'wcommero-store-builder'),
                    'style-2'  => esc_html__('Style 2', 'wcommero-store-builder'),
                    'style-3'  => esc_html__('Style 3', 'wcommero-store-builder'),
                ),
                'default' => 'style-1'

            ]
        );

        $this->add_control(
            'column',
            [
                'label'   => esc_html__('Column', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT2,
                'options' => array(
                    '2' => esc_html__('6', 'wcommero-store-builder'),
                    '3'  => esc_html__('4', 'wcommero-store-builder'),
                    '4'  => esc_html__('3', 'wcommero-store-builder'),
                    '6'  => esc_html__('2', 'wcommero-store-builder'),
                ),
                'default' => '3'

            ]
        );

        $this->add_control(
            'ppr',
            [
                'label'   => esc_html__('Amount of post to display', 'wcommero-store-builder'),
                'type'    => Controls_Manager::TEXT,
                'default' => 6
            ]
        );


        $this->end_controls_section(); // End general settings

        $this->start_controls_section(
            'Post_filter_settings',
            [
                'label' => esc_html__('Post Options', 'wcommero-store-builder'),
            ]
        );


        $this->add_control(
            'select_cat',
            [
                'label'    => esc_html__('Select Category', 'wcommero-store-builder'),
                'type'     => Controls_Manager::SELECT2,
                'description' => esc_html__('Keep Blank To Display All Categories Job', 'wcommero-store-builder'),
                'multiple' => true,
                'options'  => wcommero_post_category(),

            ]
        );


        $this->add_control(
            'exclude_cat',
            [
                'label'    => esc_html__('Exclude Category', 'wcommero-store-builder'),
                'type'     => Controls_Manager::SELECT2,
                'multiple' => true,
                'options'  => wcommero_post_category(),
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order by', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT2,
                'options' => array(
                    'author' => esc_html__('Author', 'wcommero-store-builder'),
                    'title'  => esc_html__('Title', 'wcommero-store-builder'),
                    'date'   => esc_html__('Date', 'wcommero-store-builder'),
                    'rand'   => esc_html__('Random', 'wcommero-store-builder'),
                ),
                'default' => 'date'

            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT2,
                'options' => array(
                    'desc' => esc_html__('DESC', 'wcommero-store-builder'),
                    'asc'  => esc_html__('ASC', 'wcommero-store-builder'),
                ),
                'default' => 'desc'

            ]
        );


        $this->end_controls_section(); // End Filter

        //title settings
        $this->start_controls_section(
            'title_settings',
            [
                'label' => esc_html__('Title Settings', 'wcommero-store-builder'),
            ]
        );

        $this->add_control(
            'dtitle',
            [
                'label'   => esc_html__('Display', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT2,
                'options' => array(
                    'full' => esc_html__('Full Title', 'wcommero-store-builder'),
                    'excerpt'  => esc_html__('Excerpt', 'wcommero-store-builder'),
                ),
                'default' => 'full'

            ]
        );

        $this->add_control(
            'title_excerpt_length',
            [
                'label'   => esc_html__('Title Excerpt Length', 'wcommero-store-builder'),
                'type'    => Controls_Manager::TEXT,
                'default' => 3,
                'condition' => [
                    'dtitle' => 'excerpt'
                ]
            ]
        );

        $this->add_control(
            'titltag',
            [
                'label'   => esc_html__('Title Tag', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ),
                'default' => 'h5'

            ]
        );

        $this->end_controls_section(); // End title


        // other 
        $this->start_controls_section(
            'other_settings',
            [
                'label' => esc_html__('Other Settings', 'wcommero-store-builder'),
            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label' => esc_html__('Enable Pagination?', 'wcommero-store-builder'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'wcommero-store-builder'),
                'label_off' => esc_html__('no', 'wcommero-store-builder'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );


        $this->add_control(
            'open-url',
            [
                'label'   => esc_html__('Where Open Product Post?', 'wcommero-store-builder'),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'same-window' => esc_html__('Same Window', 'wcommero-store-builder'),
                    'new-window' => esc_html__('New Window', 'wcommero-store-builder'),
                ),
                'default' => 'same-window',
                'label_block' => true
            ]
        );


        $this->end_controls_section(); // End sub title

        //Content style
        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__('Content Style', 'wcommero-store-builder'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        wcommero_elementor_style_options($this, 'Title', '{{WRAPPER}} .content .woo-title', ['style-1', 'style-2', 'style-3', 'style-4']);
        wcommero_elementor_style_options($this, 'Category', '{{WRAPPER}} .content .category', ['style-1', 'style-2', 'style-3', 'style-4']);
        wcommero_elementor_style_options($this, 'Pricing', '{{WRAPPER}} .prices span', ['style-1', 'style-2', 'style-3', 'style-4']);

        wcommero_elementor_style_options($this, 'New Badge', '{{WRAPPER}} .bgc-black', ['style-1', 'style-2', 'style-3', 'style-4']);
        wcommero_elementor_style_options($this, 'New Badge Background', '{{WRAPPER}} .bgc-black', ['style-1', 'style-2', 'style-3', 'style-4'], 'background-color', false, true);

        wcommero_elementor_style_options($this, 'Sale Badge', '{{WRAPPER}} .bgc-primary', ['style-1', 'style-2', 'style-3', 'style-4']);
        wcommero_elementor_style_options($this, 'Sale Badge Background', '{{WRAPPER}} .bgc-primary', ['style-1', 'style-2', 'style-3', 'style-4'], 'background-color', false, true);

        $this->end_controls_section();
    }

    protected function render()
    {

        $settings = $this->get_settings();

        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        $args  = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $settings['ppr'],
            'paged' => $paged,
        );

        $args['orderby'] = $settings['orderby'];
        $args['order']   = $settings['order'];
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public filter query args, read-only.
        $args['s']       = isset( $_GET['keyword'] ) ? sanitize_text_field( wp_unslash( $_GET['keyword'] ) ) : '';

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public filter query args, read-only.
        if ( ! empty( $_GET['product_cat'] ) && -1 != $_GET['product_cat'] ) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public filter, value sanitized.
                'terms'    => sanitize_text_field( wp_unslash( $_GET['product_cat'] ) )
            );
        } elseif (!empty($settings['select_cat'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => array_values($settings['select_cat'])
            );
        }


        if (!empty($settings['exclude_cat'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => array_values($settings['exclude_cat']),
                'operator' => 'NOT IN'
            );
        }

        $wcommero_posts_query = new \WP_Query($args);

        include wcommero_get_template('general-one.php');
        include wcommero_get_template('general-two.php');
        include wcommero_get_template('general-three.php');
    }
}

\Elementor\Plugin::instance()->widgets_manager->register(new Wcommero_General());
