<?php
/**
 * Pagination template
 *
 * @package wcommero
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ('yes' == $settings['enable_pagination']) :
?>
    <div class="swp-container text-center">
        <nav class="swp-page-navigation">
            <?php

            $wcommero_total_pages = $wcommero_posts_query->max_num_pages;

            if ($wcommero_total_pages > 1) {

                $wcommero_current_page = (is_front_page() ? max(1, get_query_var('page')) : max(1, get_query_var('paged')));

                echo wp_kses_post( paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => '/page/%#%',
                    'current' => $wcommero_current_page,
                    'total' => $wcommero_total_pages,
                    'prev_text'    => '<i class="fa fa-angle-double-left"></i>',
                    'next_text'    => '<i class="fa fa-angle-double-right"></i>',
                )) );
            }

            ?>

        </nav>
    </div>
<?php
endif;
