<?php
/*
* Blog single post page
*/
get_header(); ?>

<main id="single-post">
  <div class="container">

    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

      <nav id="post-nav">
        <span class="prev"><?php previous_post_link('%link', '&lt; Previous'); ?></span>
        <span class="next"><?php next_post_link('%link', 'Next &gt;'); ?></span>
      </nav>

  </div>

  <div class="container narrow-post">

    <article class="post">

      <p class="date"><em><?php the_date(); ?></em></p>

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
      
      <h1 class="post-title"><?php the_title(); ?></h1>
      <div class="post-content">
        <?php the_content(); ?>
      </div>

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

    </article>

  </div>
  <div class="container">
      <nav id="post-nav">
        <span class="prev"><?php previous_post_link('%link', '&lt; Previous'); ?></span>
        <span class="next"><?php next_post_link('%link', 'Next &gt;'); ?></span>
      </nav>

    <?php
      endwhile; else: 

        theMissing();

      endif;
    ?>

  </div>

</main>

<?php include('partials/social-strip.php'); ?>

<?php get_footer();