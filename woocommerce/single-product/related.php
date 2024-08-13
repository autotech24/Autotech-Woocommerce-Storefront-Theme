<?php
/**
 * Related Products
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (is_singular('product')) {
    global $post;

    $terms = wp_get_post_terms($post->ID, 'product_cat');
    foreach ($terms as $term) {
        $cats_array[] = $term->term_id;
    }
    sort($cats_array);
    $cats_array = array(end($cats_array));

    $query_args = array('orderby' => 'rand', 'post__not_in' => array($post->ID), 'posts_per_page' => 3, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product', 'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $cats_array
        )));
    $r = new WP_Query($query_args);
    if ($r->have_posts()) { ?>

        <section class="related products">

            <?php
            $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));

            if ($heading) :
                ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php while ($r->have_posts()) : $r->the_post();
                global $product; ?>

                <?php wc_get_template_part('content', 'product'); ?>

            <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

        </section>

        <?php

        wp_reset_query();
    }
}
