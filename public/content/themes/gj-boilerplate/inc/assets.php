<?php

function enqueue_scripts() {

	// Libraries
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, null, true);
	wp_enqueue_script('main', get_bloginfo('template_directory') . '/js/main.js', array('jquery'), null, true);

	// HTML5 & Responsive Fallbacks
	wp_enqueue_script('modernizr', get_bloginfo('template_directory') . '/js/libs/modernizr.js', false, null, false);
	wp_enqueue_script('respond', get_bloginfo('template_directory') . '/js/libs/respond.min.js', false, null, false);
}
add_action('get_header', 'enqueue_scripts');
