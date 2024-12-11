<?php

/**
 * The Template for displaying product archives
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<header class="woocommerce-products-header">
  <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
    <h1 class="woocommerce-products-header__title page-title">
      <?php woocommerce_page_title(); ?>
    </h1>
  <?php endif; ?>

  <?php do_action('woocommerce_archive_description'); ?>
</header>

<div class="shop-container">
  <aside class="shop-sidebar">
    <?php
    /**
     * Hook: woocommerce_sidebar
     * @hooked woocommerce_get_sidebar - 10
     */
    do_action('woocommerce_sidebar');
    ?>
  </aside>

  <main class="shop-content">
    <?php
    if (woocommerce_product_loop()) {
      /**
       * Hook: woocommerce_before_shop_loop
       * @hooked woocommerce_output_all_notices - 10
       * @hooked woocommerce_result_count - 20
       * @hooked woocommerce_catalog_ordering - 30
       */
      do_action('woocommerce_before_shop_loop');

      woocommerce_product_loop_start();

      if (wc_get_loop_prop('total')) {
        while (have_posts()) {
          the_post();
          do_action('woocommerce_shop_loop');
          wc_get_template_part('content', 'product');
        }
      }

      woocommerce_product_loop_end();

      /**
       * Hook: woocommerce_after_shop_loop
       * @hooked woocommerce_pagination - 10
       */
      do_action('woocommerce_after_shop_loop');
    } else {
      /**
       * Hook: woocommerce_no_products_found
       * @hooked wc_no_products_found - 10
       */
      do_action('woocommerce_no_products_found');
    }
    ?>
  </main>
</div>

<?php
get_footer('shop');
