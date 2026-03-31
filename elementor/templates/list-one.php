<?php
/**
 * List one template
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
            <div class="wco-row wco-g-4">
                <div class="wco-col-xl-12">
                    <?php
                    if ($wcommero_posts_query->have_posts()) :
                        while ($wcommero_posts_query->have_posts()) : $wcommero_posts_query->the_post();
                            $wcommero_img_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            global $product;
                    ?>
                            <div class="shop-list-sidebar">
                                <div class="thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail(); ?>
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="ratting">
                                        <?php
                                        $wcommero_average = $product->get_average_rating();
                                        $wcommero_full_stars = floor($wcommero_average);
                                        $wcommero_half_star = ($wcommero_average - $wcommero_full_stars) >= 0.5 ? 1 : 0;
                                        $wcommero_empty_stars = 5 - $wcommero_full_stars - $wcommero_half_star;

                                        for ($wcommero_i = 0; $wcommero_i < $wcommero_full_stars; $wcommero_i++) {
                                            echo '<i class="fas fa-star rated"></i>';
                                        }
                                        if ($wcommero_half_star) {
                                            echo '<i class="fas fa-star-half-alt rated"></i>';
                                        }
                                        for ($wcommero_i = 0; $wcommero_i < $wcommero_empty_stars; $wcommero_i++) {
                                            echo '<i class="fas fa-star"></i>';
                                        }
                                        ?>
                                    </div>
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
                                    <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 30, '...')); ?></p>
                                    <div class="cart-btns">
                                        <?php echo wp_kses_post( wcommero_add_to_cart_button() ); ?>
                                        <div class="shop-icon">
                                            <a class="wco-image-popup" data-elementor-open-lightbox="no" href="<?php echo esc_url($wcommero_img_src[0]); ?>"><i class="far fa-eye"></i></a>
                                        </div>
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
        </div>
    </section>

<?php endif;
