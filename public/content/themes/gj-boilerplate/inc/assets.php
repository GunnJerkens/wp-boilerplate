<?php

function enqueue_scripts()
{
  // CSS
  $screen = '/style/screen.css';
  $screenFilePath = get_template_directory() . $screen;
  wp_enqueue_style('screen', get_bloginfo('template_directory') . $screen, false, filemtime($screenFilePath));

  // Libraries
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', false, null, true);

  $main = '/js/main.js';
  $mainFilePath = get_template_directory() . $main;
  wp_enqueue_script('main', get_bloginfo('template_url') . $main, array('jquery'), filemtime($mainFilePath), true);

  $parameters = array(
    'ajaxurl'   => admin_url('admin-ajax.php'),
    'nonce'     => wp_create_nonce('register'),
    'thanks'    => "Thank you, we'll be in touch soon.",
  );
  wp_localize_script('main', 'formOptions', $parameters);

  // HTML5 & responsive fallbacks
  wp_enqueue_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, null, false);

  // Font Awesome stylesheet
  // wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.6/css/all.css', false, null, false);
}

add_action('get_header', 'enqueue_scripts');
