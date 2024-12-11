<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="site-header">
    <div class="header-container">
      <div class="site-branding">
        <?php if (has_custom_logo()) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <h1 class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>">
              <?php bloginfo('name'); ?>
            </a>
          </h1>
        <?php endif; ?>
      </div>

      <nav class="main-navigation">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'menu_class'     => 'primary-menu',
          'container'      => false,
        ));
        ?>
      </nav>

      <div class="header-cart">
        <?php if (function_exists('wc_get_cart_url') && function_exists('WC')) : ?>
          <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-contents">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <div id="content" class="site-content">