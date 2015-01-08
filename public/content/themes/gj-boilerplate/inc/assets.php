<?php

function enqueue_scripts() {


  // CSS
  $screen = '/style/screen.css';
  $screenFilePath = get_template_directory() . $screen;
  wp_enqueue_style('screen', get_bloginfo('template_directory') . $screen, false, filemtime($screenFilePath));

  // Libraries
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', false, null, true);
  // If you opt to use bootstrap over the cdn, make sure to delete the ENTIRE bootstrap folder from /gj-boilerplate/js/src/
  // wp_enqueue_script('bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), null, true);

  $main = '/js/main.js';
  $mainFilePath = get_template_directory() . $main;
  wp_enqueue_script('main', get_bloginfo('template_url') . $main, array('jquery'), filemtime($mainFilePath), true);

  // HTML5 & responsive fallbacks
  wp_enqueue_script('modernizr', get_bloginfo('template_directory') . '/js/modernizr.js', false, null, false);

  // Font Awesome stylesheet
  // wp_enqueue_style('font-awesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css', false, null, false);
}
add_action('get_header', 'enqueue_scripts');
