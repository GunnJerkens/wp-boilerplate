<?php

require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/ajax.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/options.php';
require_once get_template_directory() . '/inc/content.php';

if(is_admin()) {
  (new gjOptions())->loadAdmin();
}
