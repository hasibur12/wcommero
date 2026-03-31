<?php
/**
 * Tab template (style 1)
 *
 * @package wcommero
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ($settings['style'] == 'style-1') :

?>
    <!-- Shop Section Start -->
    <section class="shop-section fix section-padding pt-0">
        <div class="wco-container">
            <div class="custom-tabs">

                <ul class="tab-buttons <?php echo esc_attr($settings['tab_alignment']); ?>">
                    <?php
                    if (is_array($settings['select_cat'])) :
                        $wcommero_i = 1;
                        foreach ($settings['select_cat'] as $term) :
                    ?>
                            <li class="tab-btn <?php echo ($wcommero_i == 1 ? 'active' : ''); ?>" data-tab="tab<?php echo esc_attr($wcommero_i); ?>">
                                <?php echo esc_html(wcommero_get_cat_name($term)); ?>
                            </li>
                    <?php $wcommero_i++;
                        endforeach;
                    endif; ?>
                </ul>

                <div class="tab-content">
                    <?php
                    $wcommero_i = 1;
                    if (is_array($settings['select_cat'])) :

                        foreach ($settings['select_cat'] as $term) :
                    ?>
                            <div class="tab <?php echo ($wcommero_i == 1 ? 'active' : ''); ?>" id="tab<?php echo esc_attr($wcommero_i); ?>">
                                <div class="wco-row wco-g-4">
                                    <?php
                                    $wcommero_args = array(
                                        'post_type'           => 'product',
                                        'post_status'         => 'publish',
                                        'ignore_sticky_posts' => 1,
                                        'posts_per_page'      => $settings['ppr'],
                                    );

                                    $wcommero_args['orderby'] = $settings['orderby'];
                                    $wcommero_args['order']   = $settings['order'];


                                    $wcommero_args['tax_query'][] = array(
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'term_id',
                                        'terms'    => $term,
                                        'operator' => 'IN',
                                    );

                                    if (!empty($settings['exclude_cat'])) {
                                        $wcommero_args['tax_query'][] = array(
                                            'taxonomy' => 'product_cat',
                                            'field'    => 'id',
                                            'terms'    => array_values($settings['exclude_cat']),
                                            'operator' => 'NOT IN'
                                        );
                                    }

                                    $wcommero_posts_query = new \WP_Query($wcommero_args);

                                    if ($wcommero_posts_query->have_posts()) :
                                        while ($wcommero_posts_query->have_posts()) : $wcommero_posts_query->the_post();
                                            $wcommero_img_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                            global $product;

                                            // Initialize regular_price variable
                                            $wcommero_regular_price = '';
                                            if ($product) {
                                                $wcommero_regular_price = $product->get_regular_price();
                                            }

                                    ?>
                                            <div class="wco-col-xl-3 wco-col-lg-4 wco-col-sm-6">
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
                                                        <?php the_post_thumbnail('wcommero_255x283'); ?>
                                                        <div class="social-style-two">
                                                            <?php echo wp_kses_post( wcommero_add_to_cart_button() ); ?>
                                                            <a class="swp-image-popup" data-elementor-open-lightbox="no" href="<?php echo esc_url($wcommero_img_src[0]); ?>"><i class="far fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <a href="#" class="category"><?php echo esc_html(wcommero_get_cat_name($term)); ?></a>
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
                                    <?php endwhile;
                                    endif; ?>
                                </div>
                            </div>
                        <?php $wcommero_i++;
                        endforeach;
                    else : ?>
                        <h3><?php echo esc_html__('Please Select A Category', 'wcommero-store-builder'); ?></h3>
                    <?php endif;  ?>
                </div>

            </div>
        </div>
    </section>
<?php endif;
