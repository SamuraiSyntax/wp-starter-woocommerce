<?php

/**
 * Admin Functions
 */

if (!defined('ABSPATH')) {
  exit;
}

class WP_Starter_Woo_Admin
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
    add_action('admin_menu', array($this, 'add_theme_options_page'));
    add_action('admin_init', array($this, 'register_settings'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    add_action('woocommerce_product_options_general_product_data', array($this, 'add_custom_product_fields'));
    add_action('woocommerce_process_product_meta', array($this, 'save_custom_product_fields'));
  }

  public function add_theme_options_page()
  {
    add_menu_page(
      __('Options WP Starter WooCommerce', 'wp-starter-woo'),
      __('WP Starter Woo', 'wp-starter-woo'),
      'manage_options',
      'wp-starter-woo-options',
      array($this, 'render_options_page'),
      'dashicons-cart',
      59
    );
  }

  public function register_settings()
  {
    register_setting('wp_starter_woo_options', 'wp_starter_woo_settings');

    add_settings_section(
      'wp_starter_woo_general',
      __('Paramètres généraux', 'wp-starter-woo'),
      array($this, 'render_section_description'),
      'wp_starter_woo_options'
    );

    // Ajouter les champs de paramètres
    add_settings_field(
      'shop_columns',
      __('Colonnes boutique', 'wp-starter-woo'),
      array($this, 'render_number_field'),
      'wp_starter_woo_options',
      'wp_starter_woo_general',
      array('field' => 'shop_columns')
    );
  }

  public function render_options_page()
  {
?>
    <div class="wrap">
      <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
      <form action="options.php" method="post">
        <?php
        settings_fields('wp_starter_woo_options');
        do_settings_sections('wp_starter_woo_options');
        submit_button();
        ?>
      </form>
    </div>
  <?php
  }

  public function render_section_description()
  {
    echo '<p>' . esc_html__('Configurez les paramètres de votre boutique.', 'wp-starter-woo') . '</p>';
  }

  public function render_number_field($args)
  {
    $options = get_option('wp_starter_woo_settings');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
  ?>
    <input type="number" name="wp_starter_woo_settings[<?php echo esc_attr($args['field']); ?>]"
      value="<?php echo esc_attr($value); ?>" min="2" max="6">
<?php
  }

  public function enqueue_admin_scripts($hook)
  {
    if ('toplevel_page_wp-starter-woo-options' !== $hook) {
      return;
    }

    wp_enqueue_style(
      'wp-starter-woo-admin',
      get_template_directory_uri() . '/assets/css/admin.css',
      array(),
      WP_STARTER_WOO_VERSION
    );

    wp_enqueue_script(
      'wp-starter-woo-admin',
      get_template_directory_uri() . '/assets/js/admin.js',
      array('jquery'),
      WP_STARTER_WOO_VERSION,
      true
    );
  }

  public function add_custom_product_fields()
  {
    woocommerce_wp_text_input(array(
      'id' => '_delivery_time',
      'label' => __('Délai de livraison', 'wp-starter-woo'),
      'placeholder' => __('Ex: 2-3 jours ouvrés', 'wp-starter-woo'),
      'desc_tip' => true,
      'description' => __('Indiquez le délai de livraison pour ce produit.', 'wp-starter-woo')
    ));
  }

  public function save_custom_product_fields($post_id)
  {
    if (isset($_POST['_delivery_time'])) {
      update_post_meta(
        $post_id,
        '_delivery_time',
        sanitize_text_field($_POST['_delivery_time'])
      );
    }
  }
}

// Initialize
WP_Starter_Woo_Admin::get_instance();
