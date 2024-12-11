<?php

/**
 * Payment Gateway Customizations
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Payments
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
    // Customize payment gateways
    add_filter('woocommerce_available_payment_gateways', array($this, 'customize_gateways'));

    // Add custom gateway settings
    add_filter('woocommerce_payment_gateways', array($this, 'add_custom_gateway'));

    // Handle payment processing
    add_action('woocommerce_payment_complete', array($this, 'payment_complete_actions'));
  }

  /**
   * Customize available payment gateways based on conditions
   */
  public function customize_gateways($gateways)
  {
    if (is_admin()) return $gateways;

    $cart_total = WC()->cart->total;

    // Disable COD for orders over 500€
    if ($cart_total > 500 && isset($gateways['cod'])) {
      unset($gateways['cod']);
    }

    // Add fee for certain payment methods
    if (isset($gateways['cod'])) {
      $gateways['cod']->title .= ' (Frais: 2€)';
    }

    return $gateways;
  }

  /**
   * Add custom payment gateway
   */
  public function add_custom_gateway($gateways)
  {
    $gateways[] = 'WC_Gateway_Custom'; // Require custom gateway class
    return $gateways;
  }

  /**
   * Actions after successful payment
   */
  public function payment_complete_actions($order_id)
  {
    $order = wc_get_order($order_id);

    // Send custom email
    do_action('wp_starter_woo_payment_confirmation', $order);

    // Add order note
    $order->add_order_note('Paiement traité avec succès');

    // Maybe update stock
    wc_maybe_reduce_stock_levels($order_id);
  }

  /**
   * Add payment info to order emails
   */
  public function add_payment_info_to_emails($order, $sent_to_admin, $plain_text, $email)
  {
    if ($plain_text) {
      echo "\n==========\n";
      echo "Informations de paiement\n";
      echo "Méthode: " . $order->get_payment_method_title() . "\n";
      echo "==========\n";
    } else {
      echo '<h2>Informations de paiement</h2>';
      echo '<p><strong>Méthode:</strong> ' . $order->get_payment_method_title() . '</p>';
    }
  }
}

// Initialize
WP_Starter_Woo_Payments::get_instance();
