<?php

function enqueue_scripts() {

  // Libraries
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, null, true);
  wp_enqueue_script('main', get_bloginfo('template_directory') . '/js/main.js', array('jquery'), null, true);

  // HTML5 & responsive fallbacks
  wp_enqueue_script('modernizr', get_bloginfo('template_directory') . '/js/modernizr.js', false, null, false);

  // Font Awesome stylesheet 
  // wp_enqueue_style('font-awesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, null, false);
}
add_action('get_header', 'enqueue_scripts');
