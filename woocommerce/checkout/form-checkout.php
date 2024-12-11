<?php

/**
 * Checkout Form
 */

if (!defined('ABSPATH')) {
  exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
  echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('Vous devez être connecté pour commander.', 'wp-starter-woo')));
  return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
  action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

  <?php if ($checkout->get_checkout_fields()) : ?>

    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

    <div class="col2-set" id="customer_details">
      <div class="col-1">
        <?php do_action('woocommerce_checkout_billing'); ?>
      </div>

      <div class="col-2">
        <?php do_action('woocommerce_checkout_shipping'); ?>
      </div>
    </div>

    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

  <?php endif; ?>

  <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

  <div id="order_review" class="woocommerce-checkout-review-order">
    <h3 id="order_review_heading"><?php esc_html_e('Votre commande', 'wp-starter-woo'); ?></h3>

    <?php do_action('woocommerce_checkout_before_order_review'); ?>

    <?php do_action('woocommerce_checkout_order_review'); ?>

    <?php do_action('woocommerce_checkout_after_order_review'); ?>
  </div>

  <!-- Progress Steps -->
  <div class="checkout-progress-steps">
    <div class="step active" data-step="billing">
      <span class="step-number">1</span>
      <span class="step-title"><?php esc_html_e('Facturation', 'wp-starter-woo'); ?></span>
    </div>
    <div class="step" data-step="shipping">
      <span class="step-number">2</span>
      <span class="step-title"><?php esc_html_e('Livraison', 'wp-starter-woo'); ?></span>
    </div>
    <div class="step" data-step="payment">
      <span class="step-number">3</span>
      <span class="step-title"><?php esc_html_e('Paiement', 'wp-starter-woo'); ?></span>
    </div>
  </div>

  <!-- Custom Fields Section -->
  <div class="custom-checkout-fields">
    <?php if (!is_user_logged_in()) : ?>
      <div class="create-account-option">
        <label>
          <input type="checkbox" name="createaccount" value="1">
          <?php esc_html_e('Créer un compte ?', 'wp-starter-woo'); ?>
        </label>
        <p class="create-account-benefits">
          <?php esc_html_e('Créez un compte pour suivre vos commandes et gérer vos informations.', 'wp-starter-woo'); ?>
        </p>
      </div>
    <?php endif; ?>

    <div class="delivery-preferences">
      <h4><?php esc_html_e('Préférences de livraison', 'wp-starter-woo'); ?></h4>
      <select name="delivery_time" class="delivery-time-select">
        <option value=""><?php esc_html_e('Choisir un créneau horaire', 'wp-starter-woo'); ?></option>
        <option value="morning"><?php esc_html_e('Matin (9h-12h)', 'wp-starter-woo'); ?></option>
        <option value="afternoon"><?php esc_html_e('Après-midi (14h-17h)', 'wp-starter-woo'); ?></option>
        <option value="evening"><?php esc_html_e('Soir (17h-20h)', 'wp-starter-woo'); ?></option>
      </select>
      <textarea name="delivery_notes"
        placeholder="<?php esc_attr_e('Instructions de livraison spéciales', 'wp-starter-woo'); ?>"></textarea>
    </div>
  </div>

  <!-- Order Summary Mobile -->
  <div class="order-summary-mobile">
    <div class="summary-header">
      <h4><?php esc_html_e('Résumé de la commande', 'wp-starter-woo'); ?></h4>
      <span class="toggle-summary">▼</span>
    </div>
    <div class="summary-content" style="display: none;">
      <?php do_action('woocommerce_checkout_order_review'); ?>
    </div>
  </div>

  <!-- Trust Badges -->
  <div class="checkout-trust-badges">
    <div class="badge">
      <i class="fas fa-lock"></i>
      <span><?php esc_html_e('Paiement sécurisé', 'wp-starter-woo'); ?></span>
    </div>
    <div class="badge">
      <i class="fas fa-truck"></i>
      <span><?php esc_html_e('Livraison rapide', 'wp-starter-woo'); ?></span>
    </div>
    <div class="badge">
      <i class="fas fa-undo"></i>
      <span><?php esc_html_e('Retours gratuits', 'wp-starter-woo'); ?></span>
    </div>
  </div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>