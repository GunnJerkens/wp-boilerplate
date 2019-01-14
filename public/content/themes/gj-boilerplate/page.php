<?php
/*
* Default page template
*/
  get_header();
?>

<main class="single page">

  <?php
    if(have_posts()) : while(have_posts()) : the_post();

      the_title();
      the_content();

    endwhile; else: 

      theMissing();

    endif;
  ?>

</main>

<?php get_footer(); ?>
