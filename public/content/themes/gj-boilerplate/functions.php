<?php

require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/content-functions.php';

$google_analytics_id = 'UA-XXXXXXXX-X';

// Navigation Menu Array
register_nav_menus( array(
  'main' => 'Main Navigation'
) );