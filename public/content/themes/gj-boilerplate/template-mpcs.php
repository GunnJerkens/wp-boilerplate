<?php
/*
* Template Name: MPCs
*/
get_header();
$mpcs = get_posts( array('posts_per_page' => -1, 'post_type' => 'MPCs', 'orderby' => 'menu_order', 'order' => 'ASC'));
$communities = get_posts( array('posts_per_page' => -1, 'post_type' => 'communities', 'orderby' => 'menu_order', 'order' => 'ASC'));
?>

<main id="mpcs">

  <div class="container">

    <div id="mpcs-wrap">
      <?php
      foreach ($mpcs as $key => $mpc) {
        $name = get_field('name', $mpc->ID);
        $region = get_field('region', $mpc->ID);
        $city = get_field('city', $mpc->ID);
        $tagline = get_field('tagline', $mpc->ID);
        $description = get_field('description', $mpc->ID);
      ?>
        <div class="mpc">
          <p><?php echo $name; ?></p>
          <p><?php echo $region->name; ?></p>
          <p><?php echo $city; ?></p>
          <p><?php echo $tagline; ?></p>
          <p><?php echo $description; ?></p>
          
          <div id="communities-wrap">
            <?php
            foreach ($communities as $key => $community) {
              $comm_name = get_field('name', $community->ID);
              $comm_tagline = get_field('tagline', $community->ID);
              $comm_description = get_field('description', $community->ID);
              $comm_mpc = get_field('mpc', $community->ID);
            ?>
              <div class="community">
                <p><?php echo $comm_name; ?></p>
                <p><?php echo $region->name; ?></p>
                <p><?php if ($comm_mpc) { echo $comm_mpc->name; } ?></p>
                <p><?php echo $city; ?></p>
                <p><?php echo $comm_tagline; ?></p>
                <p><?php echo $comm_description; ?></p>
              </div>
            <?php } ?>
          </div>

        </div>
      <?php } ?>
    </div>

  </div>

</section>

<?php get_footer(); ?>