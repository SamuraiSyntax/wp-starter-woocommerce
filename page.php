<?php
get_header();
?>

<main class="site-main">
  <?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
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
