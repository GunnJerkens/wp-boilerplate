<?php

class gjOptions {

  function __construct() {
    add_action('admin_menu', array(&$this,'gj_options_admin_actions'));
  }

  function gj_options_admin_actions() {
    add_options_page( 'GJ Options', 'GJ Options', 'administrator', 'gj_options', array(&$this,'gj_options_admin_options'));
  }

  function gj_options_admin_options() {
    include(get_template_directory() . '/options/gj-options.php');
  }

}

new gjOptions();
