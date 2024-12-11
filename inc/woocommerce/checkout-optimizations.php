<?php

/**
 * Checkout Optimizations
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Checkout
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
    // Optimisations du checkout
    add_action('woocommerce_checkout_process', array($this, 'validate_custom_fields'));
    add_action('woocommerce_checkout_update_order_meta', array($this, 'save_custom_fields'));
    add_filter('woocommerce_checkout_fields', array($this, 'customize_checkout_fields'));
    add_filter('woocommerce_default_address_fields', array($this, 'customize_address_fields'));

    // AJAX validation
    add_action('wp_ajax_validate_checkout_field', array($this, 'ajax_validate_field'));
    add_action('wp_ajax_nopriv_validate_checkout_field', array($this, 'ajax_validate_field'));
  }

  /**
   * Personnalisation des champs de checkout
   */
  public function customize_checkout_fields($fields)
  {
    // Mise en cache des champs personnalisés
    static $custom_fields = null;

    if (null !== $custom_fields) {
      return $custom_fields;
    }

    foreach ($fields as $fieldset_key => $fieldset) {
      foreach ($fieldset as $field_key => $field) {
        // Optimisation des validations
        $fields[$fieldset_key][$field_key]['class'][] = 'validate-required';
        $fields[$fieldset_key][$field_key]['custom_attributes']['data-validate'] = 'true';

        // Ajout de l'autocomplétion
        $fields[$fieldset_key][$field_key]['autocomplete'] = $this->get_autocomplete_value($field_key);
      }
    }

    $custom_fields = $fields;
    return $custom_fields;
  }

  private function get_autocomplete_value($field_key)
  {
    $autocomplete_map = array(
      'billing_first_name' => 'given-name',
      'billing_last_name'  => 'family-name',
      'billing_email'      => 'email',
      'billing_phone'      => 'tel'
    );

    return isset($autocomplete_map[$field_key]) ? $autocomplete_map[$field_key] : 'off';
  }

  /**
   * Personnalisation des champs d'adresse
   */
  public function customize_address_fields($fields)
  {
    // Optimisation du champ code postal
    $fields['postcode']['priority'] = 65;
    $fields['postcode']['class'] = array('form-row-first');
    $fields['postcode']['custom_attributes'] = array(
      'pattern' => '[0-9]*',
      'maxlength' => '5'
    );

    // Optimisation du champ ville
    $fields['city']['priority'] = 70;
    $fields['city']['class'] = array('form-row-last');

    return $fields;
  }

  /**
   * Validation des champs personnalisés
   */
  public function validate_custom_fields()
  {
    // Validation du téléphone mobile
    if (isset($_POST['billing_phone_mobile'])) {
      $phone = sanitize_text_field($_POST['billing_phone_mobile']);
      if (!preg_match('/^0[6-7][0-9]{8}$/', $phone)) {
        wc_add_notice(__('Le numéro de téléphone mobile n\'est pas valide.', 'wp-starter-woo'), 'error');
      }
    }

    // Validation du code postal
    if (isset($_POST['billing_postcode'])) {
      $postcode = sanitize_text_field($_POST['billing_postcode']);
      if (!preg_match('/^[0-9]{5}$/', $postcode)) {
        wc_add_notice(__('Le code postal n\'est pas valide.', 'wp-starter-woo'), 'error');
      }
    }
  }

  /**
   * Sauvegarde des champs personnalisés
   */
  public function save_custom_fields($order_id)
  {
    if (isset($_POST['billing_phone_mobile'])) {
      update_post_meta(
        $order_id,
        '_billing_phone_mobile',
        sanitize_text_field($_POST['billing_phone_mobile'])
      );
    }

    if (isset($_POST['shipping_instructions'])) {
      update_post_meta(
        $order_id,
        '_shipping_instructions',
        sanitize_textarea_field($_POST['shipping_instructions'])
      );
    }
  }

  /**
   * Validation AJAX des champs
   */
  public function ajax_validate_field()
  {
    check_ajax_referer('wp_starter_woo_nonce', 'nonce');

    $field_id = isset($_POST['field_id']) ? sanitize_text_field($_POST['field_id']) : '';
    $value = isset($_POST['value']) ? sanitize_text_field($_POST['value']) : '';
    $valid = true;
    $message = '';

    switch ($field_id) {
      case 'billing_phone_mobile':
        if (!preg_match('/^0[6-7][0-9]{8}$/', $value)) {
          $valid = false;
          $message = __('Le numéro de téléphone mobile n\'est pas valide.', 'wp-starter-woo');
        }
        break;

      case 'billing_postcode':
        if (!preg_match('/^[0-9]{5}$/', $value)) {
          $valid = false;
          $message = __('Le code postal n\'est pas valide.', 'wp-starter-woo');
        }
        break;
    }

    wp_send_json_success(array(
      'valid' => $valid,
      'message' => $message
    ));
  }
}

// Initialize
WP_Starter_Woo_Checkout::get_instance();
