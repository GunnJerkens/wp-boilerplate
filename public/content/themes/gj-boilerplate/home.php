<?php
/*
* Blog posts page
*/
get_header(); ?>

<main id="blog-wrap">
  <div class="container narrow">

    <?php

      $count  = 1;

      $blogArgs = [
        'paged'               => $paged,
        'post_type'           => 'post',
        'posts_per_page'      => '4'
      ];

      $blog = new WP_Query($blogArgs);

      $ajax = [
        'blog_url' => (get_option('show_on_front') == 'page') ? get_permalink( get_option('page_for_posts') ) : home_url('/'),
        'num_pages' => $blog->max_num_pages
      ];

      wp_localize_script('main', 'ajaxVars', $ajax);

    ?>

    <div id="blog-posts">

      <?php if($blog->have_posts()) : while($blog->have_posts()) : $blog->the_post(); ?>
    
        <article <?php post_class(); ?>>
          <a href="<?php echo get_the_permalink(); ?>">

          <?php
            if ( has_post_thumbnail() ) {
              $med = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
              $large = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
              $xl = wp_get_attachment_image_src( get_post_thumbnail_id(), 'x-large' );

              if ( is_sticky() ) {
                echo '<div class="post-img" style="background-image: url('.$xl[0].');"></div>';
              } else {
                echo '<div class="post-img" style="background-image: url('.$med[0].');"></div>';
              }
            }
          ?>
          </a>

          <div class="title-area">
            <ul class="post-categories">
            <?php
              $categories = get_the_category();
              foreach($categories as $category) {
                $link = get_category_link($category->term_id);
                echo '<li class="category"><a href="'.$link.'">'.$category->name.'</a></li>';
                if (count($categories) > 1) {
                  echo ',';
                }
              }
            ?>
            </ul>
            <hr>
            <div class="post-title">
              <a href="<?php echo get_the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </div>
          </div>
              
          </a>
        </article> 
      
      <?php
      
        $count++;

        endwhile; else:

          theMissing();

        endif;

        wp_reset_query();

      ?>

    </div><!-- end blog-posts -->

  </div><!-- end container -->

  <!-- <div id="ajax-posts"></div> -->

  <?php if(get_next_posts_link(null, $blog->max_num_pages) !== null) { ?>
    <div id="load-posts">
      <?php next_posts_link('Older Posts', $blog->max_num_pages); ?></div>
    </div>
  <?php } ?>

</main>

<?php include('partials/social-strip.php'); ?>

<?php get_footer();