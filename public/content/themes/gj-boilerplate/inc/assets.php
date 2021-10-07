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

  // JS
  $main = '/js/main.js';
  $mainFilePath = get_template_directory() . $main;
  wp_enqueue_script('main', get_bloginfo('template_url') . $main, array('jquery'), filemtime($mainFilePath), true);

  // HTML5 & responsive fallbacks
  // wp_enqueue_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, null, false);

  if( is_front_page() ){
    wp_enqueue_script('Home', get_template_directory_uri() .'/js/src/home.js', false, null, true);
  }

  if ( is_page() ){ //Check if we are viewing a page
    global $wp_query;
   
    //Check which template is assigned to current page we are looking at
    $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );

    // Individual page template and script file
    // if($template_name == 'template-nearby.php'){
    //   wp_enqueue_script('Nearby', get_template_directory_uri() .'/js/src/nearby.js', false, null, true);
    // }
  }

  // JS for single post type
  if( is_single() && get_post_type()=='TYPE_NAME' ){
    // wp_enqueue_script('Collection', get_template_directory_uri() .'/js/src/collection.js', false, null, true);
  }

  // Load form variables
  $parameters = array(
    'ajaxurl'   => admin_url('admin-ajax.php'),
    'nonce'     => wp_create_nonce('register'),
  );
  wp_localize_script('main', 'formOptions', $parameters);
}

add_action('get_header', 'enqueue_scripts');
