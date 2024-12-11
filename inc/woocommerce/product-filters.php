<?php

/**
 * Advanced Product Filters
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Filters
{
  private static $instance = null;
  private $default_filters = array();

  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function __construct()
  {
    $this->default_filters = array(
      'min_price' => 0,
      'max_price' => 1000,
      'categories' => array(),
      'attributes' => array(),
      'orderby' => 'date',
      'stock_status' => ''
    );

    // Actions
    add_action('wp_ajax_filter_products', array($this, 'ajax_filter_products'));
    add_action('wp_ajax_nopriv_filter_products', array($this, 'ajax_filter_products'));
    add_action('woocommerce_before_shop_loop', array($this, 'render_filter_form'), 15);

    // Filtres
    add_filter('woocommerce_product_query_tax_query', array($this, 'modify_product_query'), 10, 2);
    add_filter('woocommerce_product_query_meta_query', array($this, 'add_meta_query'), 10, 2);
  }

  /**
   * Rendu du formulaire de filtres
   */
  public function render_filter_form()
  {
    $categories = get_terms(array(
      'taxonomy' => 'product_cat',
      'hide_empty' => true
    ));

    $attributes = wc_get_attribute_taxonomies();

    $min_price = floor($this->get_min_price());
    $max_price = ceil($this->get_max_price());

    include WP_STARTER_WOO_DIR . '/woocommerce/filter-template.php';
  }

  /**
   * Obtenir le prix minimum des produits
   */
  private function get_min_price()
  {
    global $wpdb;
    $sql = "SELECT MIN(CAST(meta_value AS DECIMAL)) FROM {$wpdb->postmeta} 
                WHERE meta_key = '_price' AND post_id IN (
                    SELECT ID FROM {$wpdb->posts} 
                    WHERE post_type = 'product' 
                    AND post_status = 'publish'
                )";
    return $wpdb->get_var($sql);
  }

  /**
   * Obtenir le prix maximum des produits
   */
  private function get_max_price()
  {
    global $wpdb;
    $sql = "SELECT MAX(CAST(meta_value AS DECIMAL)) FROM {$wpdb->postmeta} 
                WHERE meta_key = '_price' AND post_id IN (
                    SELECT ID FROM {$wpdb->posts} 
                    WHERE post_type = 'product' 
                    AND post_status = 'publish'
                )";
    return $wpdb->get_var($sql);
  }

  /**
   * Filtrage AJAX des produits
   */
  public function ajax_filter_products()
  {
    check_ajax_referer('wp_starter_woo_nonce', 'nonce');

    // Cache les résultats pendant 1 heure
    $cache_key = 'product_filter_' . md5(serialize($_POST));
    $results = wp_cache_get($cache_key);

    if (false === $results) {
      $args = $this->build_query_args($_POST);
      $query = new WP_Query($args);

      ob_start();
      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
          wc_get_template_part('content', 'product');
        }
      }
      $results = ob_get_clean();
      wp_cache_set($cache_key, $results, '', HOUR_IN_SECONDS);
    }

    wp_send_json_success(array('html' => $results));
  }

  /**
   * Modification de la requête produits principale
   */
  public function modify_product_query($tax_query, $query)
  {
    // Remplacer la vérification is_main_query()
    if (!is_shop() || is_admin()) {
      return $tax_query;
    }

    // Ajout des filtres actifs à la requête principale
    if (isset($_GET['filter_categories'])) {
      $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field'    => 'term_id',
        'terms'    => array_map('absint', (array)$_GET['filter_categories'])
      );
    }

    return $tax_query;
  }
  /**
   * Ajout des meta_query pour les filtres
   */
  public function add_meta_query($meta_query, $query)
  {
    // Remplacer la vérification is_main_query()
    if (!is_shop() || is_admin()) {
      return $meta_query;
    }

    if (isset($_GET['min_price']) || isset($_GET['max_price'])) {
      $meta_query[] = array(
        'key' => '_price',
        'value' => array(
          isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0,
          isset($_GET['max_price']) ? floatval($_GET['max_price']) : PHP_FLOAT_MAX
        ),
        'type' => 'NUMERIC',
        'compare' => 'BETWEEN'
      );
    }

    return $meta_query;
  }
}

// Initialize
WP_Starter_Woo_Filters::get_instance();
