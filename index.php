<?php
get_header();
?>

<main class="site-main">
  <?php if (have_posts()) : ?>
    <div class="posts-grid">
      <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
              </a>
            </div>
          <?php endif; ?>

          <header class="entry-header">
            <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>

            <div class="entry-meta">
              <?php
              printf(
                esc_html__('Publié le %s', 'wp-starter-woo'),
                get_the_date()
              );
              ?>
            </div>
          </header>

          <div class="entry-content">
            <?php the_excerpt(); ?>
          </div>
        </article>
      <?php endwhile; ?>
    </div>

    <?php
    the_posts_pagination(array(
      'prev_text' => __('Précédent', 'wp-starter-woo'),
      'next_text' => __('Suivant', 'wp-starter-woo'),
    ));
    ?>

  <?php else : ?>
    <p><?php esc_html_e('Aucun contenu trouvé.', 'wp-starter-woo'); ?></p>
  <?php endif; ?>
</main>

<?php
get_footer();
