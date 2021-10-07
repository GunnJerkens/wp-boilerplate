<?php
/*
* Blog posts page
*/
get_header(); ?>

<main id="blog-wrap" class="single">
  <section>
    <div class="container narrow">
      <h1>Blog</h1>

      <?php
        /* Get first post in array - if a sticky post is set it will be this, otherwise it will be the latest post */
        $stickyArgs = [
          'post_type'           => 'post',
          'posts_per_page'      => '1'
        ];

        $sticky = new WP_Query($stickyArgs);
        /* $exclude used to not show the sticky/first post in array in the rest of the posts */
        $exclude = array($sticky->posts[0]->ID);

        $blogArgs = [
          'paged'               => $paged,
          'post_type'           => 'post',
          'posts_per_page'      => '3',
          'post__not_in'        => $exclude
        ];

        $count = 1;
        $blog = new WP_Query($blogArgs);

        $ajax = [
          'blog_url' => (get_option('show_on_front') == 'page') ? get_permalink( get_option('page_for_posts') ) : home_url('/'),
          'num_pages' => $blog->max_num_pages
        ];

        wp_localize_script('main', 'ajaxVars', $ajax);
      ?>

      <div id="blog-posts">

        <!-- Sticky post -->
        <?php
          if($sticky->have_posts()) : $sticky->the_post();

            if ( !is_paged() ) {
        ?>

              <article class="post sticky">
                <?php include('partials/blog-listing.php'); ?>
              </article> 
        
        <?php
            }
          endif;
        ?>

        <!-- Posts without sticky post -->
        <?php
          if($blog->have_posts()) : while($blog->have_posts()) : $blog->the_post();

            $index = $blog->current_post;

            if ($index !== null) {
        ?>
      
              <article class="post">
                <?php include('partials/blog-listing.php'); ?>
              </article> 
        
        <?php
            }
          
          $count++;

          endwhile; else:

            theMissing();

          endif;
        ?>

      </div><!-- end blog-posts -->

    </div><!-- end container -->
  </section>

  <?php if(get_next_posts_link(null, $blog->max_num_pages) !== null) { ?>
    <div id="load-posts">
      <?php next_posts_link('Older Posts', $blog->max_num_pages); ?></div>
    </div>
  <?php } ?>

</main>

<?php get_footer();