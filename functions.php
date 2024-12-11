<?php

/**
 * WP Starter WooCommerce Theme functions
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Define theme constants
define('WP_STARTER_WOO_VERSION', '1.0.0');
define('WP_STARTER_WOO_DIR', get_template_directory());
define('WP_STARTER_WOO_URI', get_template_directory_uri());

// Declare WooCommerce support
function wp_starter_woo_setup()
{
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');

  // Autres supports de thème
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'wp_starter_woo_setup');


// Vérifier si WooCommerce est activé avant de charger les fichiers
if (!function_exists('is_woocommerce_activated')) {
  function is_woocommerce_activated()
  {
    return class_exists('WooCommerce');
  }
}

// Include required files seulement si WooCommerce est activé
if (is_woocommerce_activated()) {
  $required_files = array(
    '/inc/woocommerce/template-functions.php',
    '/inc/woocommerce/product-functions.php',
    '/inc/woocommerce/cart-functions.php',
    '/inc/woocommerce/checkout-optimizations.php',
    '/inc/woocommerce/email-customizer.php',
    '/inc/woocommerce/payment-gateway.php',
    '/inc/woocommerce/product-filters.php',
    '/inc/woocommerce/admin/admin-functions.php'
  );

  foreach ($required_files as $file) {
    if (file_exists(WP_STARTER_WOO_DIR . $file)) {
      require_once WP_STARTER_WOO_DIR . $file;
    }
  }
}

// Enqueue scripts and styles
function wp_starter_woo_scripts()
{
  // Styles
  wp_enqueue_style(
    'wp-starter-woo-main',
    get_template_directory_uri() . '/assets/css/main.css',
    array(),
    WP_STARTER_WOO_VERSION
  );

  // Scripts avec conditions
  if (function_exists('is_cart')) {
    if (is_cart() || is_checkout()) {
      wp_enqueue_script('cart-ajax', WP_STARTER_WOO_URI . '/assets/js/cart-ajax.js', array('jquery'), WP_STARTER_WOO_VERSION, true);
      wp_enqueue_script('checkout-validation', WP_STARTER_WOO_URI . '/assets/js/checkout-validation.js', array('jquery'), WP_STARTER_WOO_VERSION, true);
    }

    if (is_shop() || is_product_category()) {
      wp_enqueue_script('product-filters', WP_STARTER_WOO_URI . '/assets/js/product-filters.js', array('jquery'), WP_STARTER_WOO_VERSION, true);
    }
  }
}
add_action('wp_enqueue_scripts', 'wp_starter_woo_scripts');

// Disable WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Custom image sizes
add_image_size('woo-product-thumbnail', 300, 300, true);
add_image_size('woo-product-gallery', 800, 800, true);
