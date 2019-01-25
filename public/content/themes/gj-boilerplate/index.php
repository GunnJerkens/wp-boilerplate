<?php
/*
* Default index template
*/
  get_header();
?>

<main class="single index">
  <div class="container">

    <?php
      if(have_posts()) : while(have_posts()) : the_post();

        the_title();
        the_content();

      endwhile; else: 

        theMissing();

      endif;
    ?>

  </div>
</main>

<?php get_footer(); ?>
