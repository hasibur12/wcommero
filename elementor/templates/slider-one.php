<?php
/**
 * Slider template (style 1)
 *
 * @package wcommero
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ($settings['style'] == 'style-1') :

?>
    <?php
    $wcommero_slider_settings = [
        'loop'        => !empty($settings['loop']) && $settings['loop'] === 'yes',
        'enable_nav'  => !empty($settings['enable_nav']) && $settings['enable_nav'] === 'yes',
        'enable_dots' => !empty($settings['enable_dots']) && $settings['enable_dots'] === 'yes',
        'smart_speed' => isset($settings['smart_speed']['size']) ? (int) $settings['smart_speed']['size'] : 700,
        'items'       => isset($settings['items']['size']) ? (int) $settings['items']['size'] : 3,
        'margin'      => isset($settings['margin']['size']) ? (int) $settings['margin']['size'] : 30,
    ];
    ?>
    <!-- Shop Section Start -->
    <section class="shop-section fix section-padding">
        <div class="wco-container">
            <div class="swiper shop-slider" data-slider-settings="<?php echo esc_attr(wp_json_encode($wcommero_slider_settings)); ?>">
                <div class="swiper-wrapper">
                    <?php
                    if ($wcommero_posts_query->have_posts()) :
                        while ($wcommero_posts_query->have_posts()) : $wcommero_posts_query->the_post();
                            $wcommero_img_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            global $product;

                    ?>
                            <div class="swiper-slide">
                                <div class="shop-card-items mt-0">
                                    <div class="image">
                                        <div class="badges">
                                            <?php wcommero_display_percentage_on_sale_badge(); ?>
                                            <?php
                                            $wcommero_newness_days = 30;
                                            $wcommero_created = strtotime($product->get_date_created());
                                            if ((time() - (60 * 60 * 24 * $wcommero_newness_days)) < $wcommero_created) {
                                            ?>
                                                <span class="bgc-black"><?php esc_html_e('New', 'wcommero-store-builder'); ?></span>
                                            <?php } ?>
                                        </div>
                                        <?php the_post_thumbnail(); ?>
                                        <div class="social-style-two">
                                            <?php echo wp_kses_post( wcommero_add_to_cart_button() ); ?>
                                            <a class="swp-image-popup" data-elementor-open-lightbox="no" href="<?php echo esc_url($wcommero_img_src[0]); ?>"><i class="far fa-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <?php
                                        $wcommero_categories = get_the_terms(get_the_ID(), 'product_cat');
                                        if ($wcommero_categories && !is_wp_error($wcommero_categories)) :
                                            $wcommero_category = array_shift($wcommero_categories);
                                        ?>
                                            <a href="<?php echo esc_url(get_term_link($wcommero_category)); ?>" class="category"><?php echo esc_html($wcommero_category->name); ?></a>
                                        <?php endif; ?>
                                        <<?php echo esc_attr($settings['titltag']); ?>>
                                            <a <?php echo esc_attr(('new-window' == $settings['open-url'] ? 'target="_blank"' : '')); ?> href="<?php the_permalink(); ?>" class="woo-title">
                                                <?php
                                                if ('full' == $settings['dtitle']) :

                                                    the_title();

                                                else :
                                                    echo esc_html(wp_trim_words(get_the_title(), $settings['title_excerpt_length'], ''));
                                                endif;
                                                ?>
                                            </a>
                                        </<?php echo esc_attr($settings['titltag']); ?>>
                                        <div class="prices"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php
                        wp_reset_postdata();
                    else :
                    ?>
                        <h3 class="no-post-found"><?php esc_html_e('Sorry, No Product Found', 'wcommero-store-builder') ?></h3>
                    <?php endif; ?>
                </div>
                <?php if (!empty($settings['enable_dots']) && $settings['enable_dots'] === 'yes') : ?>
                    <div class="swiper-dot text-center mt-5">
                        <div class="dot"></div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($settings['enable_nav']) && $settings['enable_nav'] === 'yes') : ?>
                <div class="array-button">
                    <button class="array-prev"><?php \Elementor\Icons_Manager::render_icon($settings['nav_left_icon'], ['aria_hidden' => 'true']); ?></button>
                    <button class="array-next"><?php \Elementor\Icons_Manager::render_icon($settings['nav_right_icon'], ['aria_hidden' => 'true']); ?></button>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif;
