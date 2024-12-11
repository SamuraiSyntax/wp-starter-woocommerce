<?php

/**
 * Template Functions
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Template
{
  private static $instance = null;

  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function __construct()
  {
    add_filter('body_class', array($this, 'add_body_classes'));
    add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_styles'));
    add_action('after_setup_theme', array($this, 'setup_theme_support'));
    add_action('widgets_init', array($this, 'register_sidebars'));
  }

  public function add_body_classes($classes)
  {
    if (function_exists('is_woocommerce_activated') && is_woocommerce_activated()) {
      $classes[] = 'woocommerce-active';
    }
    return $classes;
  }

  public function enqueue_custom_styles()
  {
    wp_enqueue_style(
      'custom-woocommerce',
      get_template_directory_uri() . '/assets/css/woocommerce.css',
      array(),
      WP_STARTER_WOO_VERSION
    );
  }

  public function setup_theme_support()
  {
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('woocommerce', array(
      'thumbnail_image_width' => 300,
      'single_image_width'    => 600,
      'product_grid'          => array(
        'default_rows'    => 3,
        'min_rows'        => 2,
        'max_rows'        => 8,
        'default_columns' => 4,
        'min_columns'     => 2,
        'max_columns'     => 5,
      ),
    ));
  }

  public function register_sidebars()
  {
    register_sidebar(array(
      'name'          => __('Sidebar Boutique', 'wp-starter-woo'),
      'id'            => 'shop-sidebar',
      'description'   => __('Widgets pour la sidebar de la boutique', 'wp-starter-woo'),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ));
  }
}

// Initialize
WP_Starter_Woo_Template::get_instance();
