<?php

/**
 * Cart Functions
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Cart
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
    // Ajax handlers
    add_action('wp_ajax_update_mini_cart', array($this, 'update_mini_cart'));
    add_action('wp_ajax_nopriv_update_mini_cart', array($this, 'update_mini_cart'));

    // Cart modifications
    add_filter('woocommerce_add_to_cart_fragments', array($this, 'cart_fragments'));
    add_action('woocommerce_before_calculate_totals', array($this, 'custom_price_rules'));

    // Cart features
    add_action('init', array($this, 'register_cart_features'));
  }

  /**
   * Update mini cart via AJAX
   */
  public function update_mini_cart()
  {
    check_ajax_referer('wp_starter_woo_nonce', 'nonce');

    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    wp_send_json_success(array(
      'fragments' => array(
        'div.widget_shopping_cart_content' => $mini_cart
      )
    ));
  }

  /**
   * Add custom fragments to cart updates
   */
  public function cart_fragments($fragments)
  {
    // Cart count
    ob_start();
?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['span.cart-count'] = ob_get_clean();

    // Cart total
    ob_start();
    ?>
    <span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
<?php
    $fragments['span.cart-total'] = ob_get_clean();

    return $fragments;
  }

  /**
   * Custom price rules (remises, etc.)
   */
  public function custom_price_rules($cart)
  {
    if (is_admin() && !defined('DOING_AJAX')) {
      return;
    }

    if (did_action('woocommerce_before_calculate_totals') >= 2) {
      return;
    }

    // Example: Remise de 10% pour les commandes de plus de 100€
    $cart_total = 0;
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
      $cart_total += $cart_item['data']->get_price() * $cart_item['quantity'];
    }

    if ($cart_total > 100) {
      foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $price = $cart_item['data']->get_price();
        $cart_item['data']->set_price($price * 0.9);
      }
    }
  }

  /**
   * Register custom cart features
   */
  public function register_cart_features()
  {
    // Cross-sells améliorés
    add_filter('woocommerce_cross_sells_total', function () {
      return 4;
    });
    add_filter('woocommerce_cross_sells_columns', function () {
      return 2;
    });

    // Minimum order amount
    add_action('woocommerce_checkout_process', array($this, 'minimum_order_amount'));
    add_action('woocommerce_before_cart', array($this, 'minimum_order_amount_notice'));
  }

  /**
   * Set minimum order amount
   */
  public function minimum_order_amount()
  {
    $minimum = 30;
    if (WC()->cart->total < $minimum) {
      wc_add_notice(
        sprintf('Le montant minimum de commande est de %s', wc_price($minimum)),
        'error'
      );
    }
  }

  /**
   * Display minimum order amount notice
   */
  public function minimum_order_amount_notice()
  {
    $minimum = 30;
    if (WC()->cart->total < $minimum) {
      wc_print_notice(
        sprintf(
          'Ajoutez encore %s pour pouvoir commander',
          wc_price($minimum - WC()->cart->total)
        ),
        'notice'
      );
    }
  }
}

// Initialize
WP_Starter_Woo_Cart::get_instance();
