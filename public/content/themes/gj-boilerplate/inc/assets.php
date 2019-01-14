<?php

function enqueue_scripts()
{
  // CSS
  $screen = '/style/screen.css';
  $screenFilePath = get_template_directory() . $screen;
  wp_enqueue_style('screen', get_bloginfo('template_directory') . $screen, false, filemtime($screenFilePath));

  // Libraries
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, null, true);

  $main = '/js/main.js';
  $mainFilePath = get_template_directory() . $main;
  wp_enqueue_script('main', get_bloginfo('template_url') . $main, array('jquery'), filemtime($mainFilePath), true);

  $parameters = array(
    'ajaxurl'   => admin_url('admin-ajax.php'),
    'nonce'     => wp_create_nonce('register'),
    'thanks'    => "Thank you, we'll be in touch soon.",
  );
  wp_localize_script('main', 'formOptions', $parameters);

  // JS for home page only
  if( is_front_page() ){
    // wp_enqueue_script('Home', get_template_directory_uri() .'/js/src/home.js', false, null, true);
  }

  // JS for single post type
  if( is_single() && get_post_type()=='TYPE_NAME' ){
    // wp_enqueue_script('Collection', get_template_directory_uri() .'/js/src/collection.js', false, null, true);
  }

  // JS for specific templates
  if ( is_page() ){ //Check if we are viewing a page
    global $wp_query;
   
    //Check which template is assigned to current page we are looking at
    $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );

    // Libs used
    // $imagesLoaded = 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js';
    // $masonry = '/js/src/libs/masonry.pkgd.min.js';
    // $slick = '/js/src/libs/slick.min.js';

    // JS for specific page
    if($template_name == 'template-collections.php'){
      // wp_enqueue_script('Collections', get_template_directory_uri() .'/js/src/collections.js', false, null, true);	
    }

    // JS for specific page with libs
    if($template_name == 'template-gallery.php'){
      // wp_enqueue_script('imagesloaded', $imagesLoaded, false, null, true);
      // wp_enqueue_script('Masonry', get_template_directory_uri() .$masonry, false, null, true);
      // wp_enqueue_script('Slick', get_template_directory_uri() .$slick, false, null, true);
      // wp_enqueue_script('Gallery', get_template_directory_uri() .'/js/src/gallery.js', false, null, true);	
    }
  }
}

add_action('get_header', 'enqueue_scripts');
