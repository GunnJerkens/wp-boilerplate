<?php

function enqueue_scripts() {

	// Libraries
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, null, true);
	wp_enqueue_script('modernizr', get_bloginfo('template_directory') . '/js/libs/modernizr.js', false, null, false);
	wp_enqueue_script('respond', get_bloginfo('template_directory') . '/js/libs/respond.min.js', false, null, false);

	// Plugins
	wp_enqueue_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('jquery'), null, true);
	wp_enqueue_script('placeholder', get_bloginfo('template_directory') . '/js/libs/jquery.placeholder.min.js', array('jquery'), null, true);
	wp_enqueue_script('imagesloaded', get_bloginfo('template_directory') . '/js/libs/jquery.imagesloaded.min.js', array('jquery'), '2.1.1', true);

	// Misc
	wp_enqueue_script('plugins', get_bloginfo('template_directory') . '/js/plugins.js', false, '0', true);
	wp_enqueue_script('custom', get_bloginfo('template_directory') . '/js/script.js', array('jquery'), '0', true);
}
add_action('get_header', 'enqueue_scripts');
