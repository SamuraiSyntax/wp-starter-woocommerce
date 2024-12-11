<?php
get_header();
?>

<main class="site-main">
  <?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

        <div class="entry-meta">
          <?php
          printf(
            esc_html__('Publié le %s par %s', 'wp-starter-woo'),
            get_the_date(),
            get_the_author()
          );
          ?>
        </div>
      </header>

      <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
          <?php the_post_thumbnail('large'); ?>
        </div>
      <?php endif; ?>

      <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
          'before' => '<div class="page-links">' . esc_html__('Pages:', 'wp-starter-woo'),
          'after'  => '</div>',
        ));
        ?>
      </div>

      <footer class="entry-footer">
        <?php
        $categories_list = get_the_category_list(esc_html__(', ', 'wp-starter-woo'));
        if ($categories_list) {
          printf('<span class="cat-links">' . esc_html__('Catégories: %1$s', 'wp-starter-woo') . '</span>', $categories_list);
        }

        $tags_list = get_the_tag_list('', esc_html__(', ', 'wp-starter-woo'));
        if ($tags_list) {
          printf('<span class="tags-links">' . esc_html__('Tags: %1$s', 'wp-starter-woo') . '</span>', $tags_list);
        }
        ?>
      </footer>
    </article>

    <?php
    if (comments_open() || get_comments_number()) :
      comments_template();
    endif;
    ?>

  <?php endwhile; ?>
</main>

<?php
get_sidebar();
get_footer();
