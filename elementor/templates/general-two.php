<?php
/**
 * List one template (style 2)
 *
 * @package wcommero
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ($settings['style'] == 'style-2') :
?>
    <section class="shop-section fix section-padding">
        <div class="wco-container">
            <div class="wco-row wco-g-4">
                <?php
                if ($wcommero_posts_query->have_posts()) :
                    while ($wcommero_posts_query->have_posts()) : $wcommero_posts_query->the_post();
                        $wcommero_img_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        global $product;
                ?>
                        <div class="wco-col-xl-<?php echo esc_attr($settings['column']); ?> wco-col-lg-4 wco-col-sm-6">
                            <div class="shop-card-items mt-0 hover-style-2">
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
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail(); ?>
                                    </a>
                                    <div class="social-style-two">
                                        <?php echo wp_kses_post( wcommero_add_to_cart_button() ); ?>
                                        <a class="wco-image-popup" data-elementor-open-lightbox="no" href="<?php echo esc_url($wcommero_img_src[0]); ?>"><i class="far fa-eye"></i></a>
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
                                    <h6>
                                        <a <?php echo esc_attr(('new-window' == $settings['open-url'] ? 'target="_blank"' : '')); ?> href="<?php the_permalink(); ?>" class="woo-title">
                                            <?php
                                            if ('full' == $settings['dtitle']) :
                                                the_title();
                                            else :
                                                echo esc_html(wp_trim_words(get_the_title(), $settings['title_excerpt_length'], ''));
                                            endif;
                                            ?>
                                        </a>
                                    </h6>
                                    <div class="prices"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php include wcommero_get_template('pagination.php'); ?>
                <?php
                    wp_reset_postdata();
                else :
                ?>
                    <h3 class="no-post-found"><?php esc_html_e('Sorry, No Product Found', 'wcommero-store-builder') ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif;
