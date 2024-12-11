<?php

/**
 * Customer completed order email
 */

if (!defined('ABSPATH')) {
  exit;
}

?>

<div class="email-wrapper">
  <?php do_action('woocommerce_email_header', $email_heading, $email); ?>

  <div class="email-intro">
    <p><?php printf(esc_html__('Bonjour %s,', 'wp-starter-woo'), esc_html($order->get_billing_first_name())); ?></p>
    <p>
      <?php esc_html_e('Nous vous confirmons que votre commande a été expédiée. Voici les détails :', 'wp-starter-woo'); ?>
    </p>
  </div>

  <div class="order-details">
    <h2>
      <?php printf(esc_html__('Commande #%s', 'wp-starter-woo'), esc_html($order->get_order_number())); ?>
      <span class="order-date">
        (<?php printf(esc_html__('Passée le %s', 'wp-starter-woo'), esc_html(wc_format_datetime($order->get_date_created()))); ?>)
      </span>
    </h2>

    <table class="order-items">
      <thead>
        <tr>
          <th><?php esc_html_e('Produit', 'wp-starter-woo'); ?></th>
          <th><?php esc_html_e('Quantité', 'wp-starter-woo'); ?></th>
          <th><?php esc_html_e('Prix', 'wp-starter-woo'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($order->get_items() as $item_id => $item) :
          $product = $item->get_product();
        ?>
          <tr>
            <td>
              <?php echo esc_html($item->get_name()); ?>
              <?php
              if ($product && $product->get_sku()) {
                echo ' (' . esc_html__('SKU:', 'wp-starter-woo') . ' ' . esc_html($product->get_sku()) . ')';
              }
              ?>
            </td>
            <td><?php echo esc_html($item->get_quantity()); ?></td>
            <td><?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <?php
        foreach ($order->get_order_item_totals() as $key => $total) :
        ?>
          <tr>
            <th scope="row" colspan="2"><?php echo esc_html($total['label']); ?></th>
            <td><?php echo wp_kses_post($total['value']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tfoot>
    </table>
  </div>

  <div class="shipping-info">
    <h3><?php esc_html_e('Informations de livraison', 'wp-starter-woo'); ?></h3>
    <p>
      <?php echo wp_kses_post($order->get_formatted_shipping_address()); ?>
      <?php if ($order->get_shipping_method()) : ?>
        <br><strong><?php esc_html_e('Méthode :', 'wp-starter-woo'); ?></strong>
        <?php echo esc_html($order->get_shipping_method()); ?>
      <?php endif; ?>
    </p>
    <?php if ($tracking = $order->get_meta('_tracking_number')) : ?>
      <p>
        <strong><?php esc_html_e('Numéro de suivi :', 'wp-starter-woo'); ?></strong>
        <?php echo esc_html($tracking); ?>
      </p>
    <?php endif; ?>
  </div>

  <div class="customer-actions">
    <p><?php
        printf(
          wp_kses(
            __('Vous pouvez suivre votre commande et télécharger votre facture depuis <a href="%s">votre compte</a>.', 'wp-starter-woo'),
            array('a' => array('href' => array()))
          ),
          esc_url(wc_get_page_permalink('myaccount'))
        );
        ?></p>
  </div>

  <div class="email-footer">
    <?php if ($additional_content) : ?>
      <p><?php echo wp_kses_post($additional_content); ?></p>
    <?php endif; ?>

    <div class="social-links">
      <p><?php esc_html_e('Suivez-nous sur les réseaux sociaux :', 'wp-starter-woo'); ?></p>
      <a href="#" class="social-link">Facebook</a>
      <a href="#" class="social-link">Instagram</a>
      <a href="#" class="social-link">Twitter</a>
    </div>
  </div>

  <?php do_action('woocommerce_email_footer', $email); ?>
</div>