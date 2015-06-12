<?php

class gjOptions {

  /**
   * Private class vars
   *
   * @var $prefix string
   */
  private $prefix;

  /**
   * Constructor
   */
  function __construct()
  {
    $this->prefix = "gj_options_";
  }

  /**
   * Loads admin
   *
   * @return void
   */
  public function loadAdmin()
  {
    add_action('admin_menu', array(&$this,'adminPage'));
  }

  /**
   * Adds the menu option
   *
   * @return void
   */
  public function adminPage() {
    add_menu_page('GJ Options', 'GJ Options', 'administrator', 'gj_options', array(&$this,'adminTemplates'), 'dashicons-admin-tools', 99);
  }

  /**
   * Includes the admin template
   *
   * @return void
   */
  public function adminTemplates() {
    include(get_template_directory() . '/options/gj-options.php');
  }

  /**
   * Saves options to the database
   *
   * @param array
   *
   * @return object
   */
  public function updateOptions()
  {

  }

  /**
   * Retrieves options to the database
   *
   * @return object
   */
  public function requestOptions()
  {

  }

  /**
   * Deletes options from the database
   *
   * @return void
   */
  public function deleteOptions()
  {

  }

}

(new gjOptions())->loadAdmin();

