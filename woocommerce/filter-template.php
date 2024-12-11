<?php

/**
 * Product filter template
 */

defined('ABSPATH') || exit;
?>

<form class="woo-filter-form" method="post">
  <div class="filters-grid">
    <!-- Prix -->
    <div class="filter-group">
      <h4><?php esc_html_e('Prix', 'wp-starter-woo'); ?></h4>
      <div class="price-slider">
        <input type="range" name="min_price" min="0" max="1000" value="0">
        <input type="range" name="max_price" min="0" max="1000" value="1000">
        <div class="price-inputs">
          <input type="number" name="min_price_input" value="0">
          <span>-</span>
          <input type="number" name="max_price_input" value="1000">
        </div>
      </div>
    </div>

    <!-- Catégories -->
    <div class="filter-group">
      <h4><?php esc_html_e('Catégories', 'wp-starter-woo'); ?></h4>
      <div class="checkbox-group">
        <?php foreach ($categories as $category) : ?>
          <label>
            <input type="checkbox" name="categories[]" value="<?php echo esc_attr($category->term_id); ?>">
            <?php echo esc_html($category->name); ?>
            <span class="count">(<?php echo esc_html($category->count); ?>)</span>
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Attributs -->
    <?php foreach ($attributes as $attribute) :
      $terms = get_terms([
        'taxonomy' => wc_attribute_taxonomy_name($attribute->attribute_name),
        'hide_empty' => true,
      ]);
    ?>
      <div class="filter-group">
        <h4><?php echo esc_html($attribute->attribute_label); ?></h4>
        <div class="checkbox-group">
          <?php foreach ($terms as $term) : ?>
            <label>
              <input type="checkbox" name="attributes[<?php echo esc_attr($attribute->attribute_name); ?>][]"
                value="<?php echo esc_attr($term->term_id); ?>">
              <?php echo esc_html($term->name); ?>
              <span class="count">(<?php echo esc_html($term->count); ?>)</span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="filter-actions">
    <button type="submit" class="apply-filters">
      <?php esc_html_e('Appliquer les filtres', 'wp-starter-woo'); ?>
    </button>
    <button type="button" class="reset-filters">
      <?php esc_html_e('Réinitialiser', 'wp-starter-woo'); ?>
    </button>
  </div>

  <?php wp_nonce_field('wp_starter_woo_filter_nonce', 'filter_nonce'); ?>
</form>