<?php
/*
* Default index template
*/
get_header();

echo '<section class="single index">';

  if(have_posts()) : while(have_posts()) : the_post();

    the_title();
    the_content();

  endwhile; else: 

    theMissing();

  endif;

echo '</section>';

get_footer();
