<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}
/*
 * @package shop builder
 * since 1.0.0
 * 
*/


// image size
add_image_size('wcommero_255x283', 255, 283, true);
add_image_size('wcommero_260x290', 260, 290, false);
add_image_size('wcommero_152x244', 152, 244, false);
add_image_size('wcommero_540x728', 540, 728, false);



if (!function_exists('wcommero_post_query')) {
  function wcommero_post_query($post_type)
  {
    $post_list = get_posts(array(
      'post_type' => $post_type,
      'showposts' => -1,
    ));
    $posts = array();

    if (!empty($post_list) && !is_wp_error($post_list)) {
      foreach ($post_list as $post) {
        $options[$post->ID] = $post->post_title;
      }
      return $options;
    }
  }
}

if (!function_exists('wcommero_post_category')) {
  //select category
  function wcommero_post_category($terms = 'product_cat')
  {

    $categories = get_terms(array(
      'taxonomy' => 'product_cat',
      'hide_empty' => false
    ));

    $options = array();

    if (!is_wp_error($categories) && !empty($categories)) {
      foreach ($categories as $category) {
        // Handle both array and object formats
        $term_id = is_array($category) ? $category['term_id'] : $category->term_id;
        $name = is_array($category) ? $category['name'] : $category->name;

        $options[$term_id] = $name;
      }
    }

    return $options;
  }
}

if (!function_exists('wcommero_select_post')) {
  //select post 
  function wcommero_select_post()
  {

    $args       = array('post_type' => 'product', 'posts_per_page' => -1);
    $post_lists = [];

    if ($postlists = get_posts($args)) {
      foreach ($postlists as $postlist) {
        (int) $post_lists[$postlist->ID] = $postlist->post_title;
      }
    } else {
      (int) $post_lists['0'] = esc_html__('No Post Found', 'wcommero-store-builder');
    }

    return $post_lists;
  }
}

if (!function_exists('wcommero_get_cat_name')) {
  function wcommero_get_cat_name($cat_id)
  {
    $cat_id   = (int) $cat_id;
    $category = get_term($cat_id, 'product_cat');

    if (!$category || is_wp_error($category)) {
      return '';
    }

    return $category->name;
  }
}

if (!function_exists('wcommero_get_cat_slug')) {
  // category slug
  function wcommero_get_cat_slug($cat_id)
  {
    $cat_id   = (int) $cat_id;
    $category = get_term($cat_id, 'product_cat');

    if (!$category || is_wp_error($category)) {
      return '';
    }

    return $category->slug;
  }
}


if (!function_exists('wcommero_slug')) {
  function wcommero_slug()
  {
    global $post;

    $wcommero_link = get_permalink($post->ID);

    if (empty($wcommero_link)) {
      return FALSE;
    } else {
      $wcommero_link = str_replace(home_url('/'), '', $wcommero_link);
      return $wcommero_link;
    }
  }
}


if (!function_exists('wcommero_get_template')) :
  function wcommero_get_template($template_name = null)
  {
    $template_path = apply_filters('wcommero-elementor/template-path', 'elementor-templates/');
    $template = locate_template($template_path . $template_name);
    if (!$template) {
      $template = WCSB_ELEMENTOR  . '/templates/' . $template_name;
    }
    if (file_exists($template)) {
      return $template;
    } else {
      return false;
    }
  }
endif;


if (!function_exists('wcommero_display_percentage_on_sale_badge')) {
  function wcommero_display_percentage_on_sale_badge()
  {
    global $product;

    if ($product->is_on_sale()) {
      $discount = 0;

      if ($product->is_type('variable')) {
        // Get the variation prices
        $prices = $product->get_variation_prices();

        // Get the minimum regular price for the variable product
        $min_regular_price = min($prices['regular_price']);

        // Get the minimum sale price for the variable product
        $min_sale_price = min(array_filter($prices['sale_price']));

        if ($min_regular_price > 0) {
          $discount = round((($min_regular_price - $min_sale_price) / $min_regular_price) * 100);
        }
      } else {
        $regular_price = $product->get_regular_price();
        if ($regular_price) {
          $sale_price = $product->get_sale_price();
          $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
        }
      }

      if ($discount > 0) {
        echo '<span class="bgc-primary">' . esc_html((string) $discount) . '% </span>';
      }
    }
  }
}



if (!function_exists('wcommero_add_to_cart_button')) {
  function wcommero_add_to_cart_button()
  {
    global $product;
    $wcommero_ajax_cart_class = (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' ? 'wcommero_ajax' : '');
    if ($product->is_type('variable')) {

      return sprintf(
        '<a href="%s" class="%s">%s</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(implode(' ', array_filter(array(
          'button',
          'product_type_' . $product->get_type(),
          'swp-readmore-arrow swp-add-to-cart'
        )))),
        '<i class="fas fa-shopping-cart"></i>'
      );
    } else {
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce wc_implode_html_attributes returns sanitized attribute string.
      return sprintf(
        '<a href="%s" data-quantity="1" class="%s" %s>%s</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(implode(' ', array_filter(array(
          'button',
          'product_type_' . $product->get_type(),
          $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
          $product->supports('ajax_add_to_cart') ? 'swp-readmore-arrow swp-add-to-cart ajax_add_to_cart' : 'swp-readmore-arrow swp-add-to-cart ',
          $wcommero_ajax_cart_class
        )))),
        wc_implode_html_attributes(array(
          'data-product_id'  => $product->get_id(),
          'data-product_sku' => $product->get_sku(),
          'aria-label'       => $product->add_to_cart_description(),
          'rel'              => 'nofollow',
        )),
        '<i class="fas fa-shopping-cart"></i>'
      );
    }
  }
}


if (!function_exists('wcommero_add_to_cart_text_button')) {
  function wcommero_add_to_cart_text_button()
  {
    global $product;
    $wcommero_ajax_cart_class = (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' ? 'wcommero_ajax' : '');
    if ($product->is_type('variable')) {

      echo sprintf(
        '<a href="%s" class="%s">%s</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(implode(' ', array_filter(array(
          'button',
          'product_type_' . $product->get_type(),
          'swp-readmore-arrow swp-add-to-cart swp-readmore-arrow-btn'
        )))),
        esc_html($product->add_to_cart_text())
      );
    } else {
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce wc_implode_html_attributes returns sanitized attribute string.
      echo sprintf(
        '<a href="%s" data-quantity="1" class="%s" %s>%s</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(implode(' ', array_filter(array(
          'button',
          'product_type_' . $product->get_type(),
          $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
          $product->supports('ajax_add_to_cart') ? 'swp-readmore-arrow swp-add-to-cart ajax_add_to_cart swp-readmore-arrow-btn' : 'swp-readmore-arrow swp-add-to-cart swp-readmore-arrow-btn',
          $wcommero_ajax_cart_class
        )))),
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WooCommerce wc_implode_html_attributes returns sanitized attribute string.
        wc_implode_html_attributes(array(
          'data-product_id'  => $product->get_id(),
          'data-product_sku' => $product->get_sku(),
          'aria-label'       => $product->add_to_cart_description(),
          'rel'              => 'nofollow',
        )),
        esc_html($product->add_to_cart_text())
      );
    }
  }
}


add_filter('woocommerce_add_to_cart_fragments', 'wcommero_add_to_cart_message_ajax');
if (!function_exists('wcommero_add_to_cart_message_ajax')) {
  function wcommero_add_to_cart_message_ajax($fragments)
  {
    // Customize the message
    $message = '<div id="custom-message" class="custom-message"><i class="fas fa-check"></i>' . esc_html__('Product added successfully', 'wcommero-store-builder') . '</div>';
    $fragments['custom_message'] = $message;
    return $fragments;
  }
}

if (!function_exists('wcommero_invert_formatted_sale_price')) {
  add_filter('woocommerce_format_sale_price', 'wcommero_invert_formatted_sale_price', 10, 3);
  function wcommero_invert_formatted_sale_price($price, $regular_price, $sale_price)
  {
    return '<ins>' . (is_numeric($sale_price) ? wc_price($sale_price) : $sale_price) . '</ins> <del>' . (is_numeric($regular_price) ? wc_price($regular_price) : $regular_price) . '</del>';
  }
}

if (!function_exists('wcommero_body_classes')) {
  function wcommero_body_classes($classes)
  {
    $classes[] = 'wcommero product';

    return $classes;
  }
  add_filter('body_class', 'wcommero_body_classes');
}


if (!function_exists('wcommero_elementor_style_options')) :
  function wcommero_elementor_style_options($agrs, $label, $selector, $condition, $style = 'color', $typo = true, $color = true)
  {

    if ($style == 'background-color') :
      if ($color) :
        $agrs->add_control(
          str_replace(' ', '_', $label) . '_color',
          [
            'label' => __('Background Color', 'wcommero-store-builder'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
              $selector => $style . ': {{VALUE}} !important;',
            ],
            'condition' => [
              'style' => $condition
            ]
          ]
        );
      endif;
      return;
    endif;

    //Label
    $agrs->add_control(
      str_replace(' ', '_', $label) . '_title',
      [
        'type' => \Elementor\Controls_Manager::HEADING,
        // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText -- Dynamic label passed by caller.
        'label' => esc_html( $label ), // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText -- Dynamic label passed by caller.
        'separator' => 'after',
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $agrs->add_responsive_control(
      str_replace(' ', '_', $label) . '_padding',
      [
        'label' => __(' Padding', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $agrs->add_responsive_control(
      str_replace(' ', '_', $label) . '_margin',
      [
        'label' => __(' Margin', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    if ($typo) :
      $agrs->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
          'name' => str_replace(' ', '_', $label) . '_typo',
          'label' => esc_html__(' Typography', 'wcommero-store-builder'),
          'selector' => $selector,
          'condition' => [
            'style' => $condition
          ]
        ]
      );

    endif;
    if ($color) :
      $agrs->add_control(
        str_replace(' ', '_', $label) . '_color',
        [
          'label' => __('Color', 'wcommero-store-builder'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            $selector => $style . ': {{VALUE}} !important;',
          ],
          'condition' => [
            'style' => $condition
          ]
        ]
      );
    endif;
  }
endif;

if (!function_exists('wcommero_elementor_button_style_options')) :
  function wcommero_elementor_button_style_options($init, $label, $selector, $hover_bg_selector = '', $condition = 'layout_one')
  {
    //Label
    $init->add_control(
      str_replace(' ', '_', $label) . '_subtitle_label',
      [
        'type' => \Elementor\Controls_Manager::HEADING,
        // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText -- Dynamic label passed by caller.
        'label' => esc_html( $label ), // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText -- Dynamic label passed by caller.
        'separator' => 'after',
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_responsive_control(
      str_replace(' ', '_', $label) . '_padding',
      [
        'label' => __('Padding', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => str_replace(' ', '_', $label) . '_typography',
        'selector' => $selector,
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => str_replace(' ', '_', $label) . '_border',
        'selector' => $selector,
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_border_radius',
      [
        'label' => __('Border Radius', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => str_replace(' ', '_', $label) . '_box_shadow',
        'selector' => $selector,
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_hr',
      [
        'type' => \Elementor\Controls_Manager::DIVIDER,
        'style' => 'thick',
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->start_controls_tabs(str_replace(' ', '_', $label) . '_tabs_button');

    $init->start_controls_tab(
      str_replace(' ', '_', $label) . '_tab_button_normal',
      [
        'label' => __('Normal', 'wcommero-store-builder'),
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_color',
      [
        'label' => __('Text Color', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          $selector => 'color: {{VALUE}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_bg_color',
      [
        'label' => __('Background Color', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          $selector => 'background-color: {{VALUE}} !important;',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->end_controls_tab();

    $init->start_controls_tab(
      str_replace(' ', '_', $label) . '_tab_button_hover',
      [
        'label' => __('Hover', 'wcommero-store-builder'),
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_hover_color',
      [
        'label' => __('Text Color', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          $selector . ':hover,' . $selector . ':focus' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_hover_bg_color',
      [
        'label' => __('Background Color', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          $hover_bg_selector => 'background-color: {{VALUE}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->add_control(
      str_replace(' ', '_', $label) . '_hover_border_color',
      [
        'label' => __('Border Color', 'wcommero-store-builder'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'condition' => [
          'button_border_border!' => '',
        ],
        'selectors' => [
          $selector . ':hover,' . $selector . ':focus' => 'border-color: {{VALUE}};',
        ],
        'condition' => [
          'style' => $condition
        ]
      ]
    );

    $init->end_controls_tab();
    $init->end_controls_tabs();
  }
endif;
