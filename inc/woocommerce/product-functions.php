<?php

/**
 * Product Functions
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Products
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
    add_filter('woocommerce_product_tabs', array($this, 'customize_product_tabs'));
    add_action('woocommerce_single_product_summary', array($this, 'add_custom_fields'), 25);
    add_filter('woocommerce_related_products_args', array($this, 'customize_related_products'));
    add_filter('woocommerce_product_related_products_heading', array($this, 'change_related_products_title'));
  }

  public function customize_product_tabs($tabs)
  {
    // Personnaliser l'onglet description
    if (isset($tabs['description'])) {
      $tabs['description']['title'] = __('Détails du produit', 'wp-starter-woo');
      $tabs['description']['priority'] = 5;
    }

    // Ajouter un nouvel onglet
    $tabs['custom_tab'] = array(
      'title'    => __('Informations supplémentaires', 'wp-starter-woo'),
      'priority' => 15,
      'callback' => array($this, 'custom_tab_content')
    );

    return $tabs;
  }

  public function custom_tab_content()
  {
    // Contenu de l'onglet personnalisé
    echo '<h2>' . esc_html__('Informations supplémentaires', 'wp-starter-woo') . '</h2>';
    echo '<p>' . esc_html__('Contenu personnalisé ici...', 'wp-starter-woo') . '</p>';
  }

  public function add_custom_fields()
  {
    global $product;

    // Exemple d'ajout de champ personnalisé
    $delivery_time = get_post_meta($product->get_id(), '_delivery_time', true);
    if ($delivery_time) {
      echo '<div class="delivery-time">';
      echo '<span class="label">' . esc_html__('Délai de livraison:', 'wp-starter-woo') . '</span>';
      echo '<span class="value">' . esc_html($delivery_time) . '</span>';
      echo '</div>';
    }
  }

  public function customize_related_products($args)
  {
    $args['posts_per_page'] = 4; // Nombre de produits reliés
    $args['columns'] = 4; // Nombre de colonnes
    return $args;
  }

  public function change_related_products_title()
  {
    return __('Produits similaires', 'wp-starter-woo');
  }
}

// Initialize
WP_Starter_Woo_Products::get_instance();
