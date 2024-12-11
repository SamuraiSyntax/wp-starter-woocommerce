</div><!-- #content -->

<footer class="site-footer">
  <div class="footer-widgets">
    <div class="footer-container">
      <?php if (is_active_sidebar('footer-1')) : ?>
        <div class="footer-column">
          <?php dynamic_sidebar('footer-1'); ?>
        </div>
      <?php endif; ?>

      <?php if (is_active_sidebar('footer-2')) : ?>
        <div class="footer-column">
          <?php dynamic_sidebar('footer-2'); ?>
        </div>
      <?php endif; ?>

      <?php if (is_active_sidebar('footer-3')) : ?>
        <div class="footer-column">
          <?php dynamic_sidebar('footer-3'); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-container">
      <div class="copyright">
        <?php
        printf(
          esc_html__('© %1$s %2$s. Tous droits réservés.', 'wp-starter-woo'),
          date('Y'),
          get_bloginfo('name')
        );
        ?>
      </div>
      <?php
      wp_nav_menu(array(
        'theme_location' => 'footer',
        'menu_class'     => 'footer-menu',
        'container'      => false,
      ));
      ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>