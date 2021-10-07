<?php
/*
* Blog single post page
*/
get_header(); ?>

<main id="single-post" class="single">

  <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

    <article class="post">

      <div class="container">
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
        <picture>
          <source media="(max-width: 500px)" srcset="<?php echo $med[0]; ?>">
          <source media="(max-width: 1024px)" srcset="<?php echo $large[0]; ?>">
          <img class="post-img" src="<?php echo $xl[0]; ?>" alt="<?php the_title(); ?>" >
        </picture>
      </div><!-- end container -->
      
      <div class="container flex">

        <div class="post-content">
          <h1 class="post-title"><?php the_title(); ?></h1>
          <?php the_content(); ?>
        </div>

        <div class="sidebar">
          <h2>In Case You Missed It</h2>
          <ul>
          <?php $blogArgs = [
              'post_type'           => 'post',
              'posts_per_page'      => '5',
            ];

            $blog = new WP_Query($blogArgs);

            if($blog->have_posts()) : while($blog->have_posts()) : $blog->the_post(); ?>

            <li class="missed post"><?php
              $permalink = get_the_permalink();
              echo '<h3>';
              the_title();
              echo '</h3>';
              echo '<p><a class="read-more" href="'.$permalink.'">Read More <i class="fa fa-chevron-right"></i></a></p>'; ?>
            </li><?php

            endwhile; else:

            endif; ?>
          </ul>
        </div>
      </div><!-- end container flex -->

    </article>

  <?php endwhile; else: ?>

    <div class="container"> 
      <?php echo theMissing(); ?>
    </div>

  <?php endif; ?>

</main>

<?php get_footer();