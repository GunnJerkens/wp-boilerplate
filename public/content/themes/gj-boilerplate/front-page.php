<?php
/*
* Default page template
*/
get_header();
?>

<main id="home">

  <div id="hero">
    <div id="hero-slider">
      <?php respImg(
        ['500','1024'],
        'home-hero-01',
        'hero-img',
        'Mother and daughter making cookies',
        'jpg'
        ); ?>
      <div id="scroll-arrow">
        <svg class="icon-chevron scroll-fade" title="Scroll down"><use xlink:href="#chevron-right"></use></svg>
      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>
