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
    $this->prefix = "gj_options";
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
  public function updateOptions($data)
  {
    $data = $this->cleanFields($data);
    update_option($this->prefix, json_encode($data));

    return (object) $this->unslashFields($data);
  }

  /**
   * Retrieves options to the database
   *
   * @return object
   */
  public function requestOptions()
  {
    $data = (array) json_decode(get_option($this->prefix));

    return (object) $this->unslashFields($data);
  }

  /**
   * Deletes options from the database
   *
   * @return void
   */
  public function deleteOptions()
  {
    delete_option($this->prefix);
  }

  /**
   * Unset unneeded fields, set empty strings to false, strip_tags
   *
   * @param array
   *
   * @return array
   */
  private function cleanFields($data)
  {
    // Remove fields that should not be saved
    $fields = ['gj_hidden', '_wpnonce', '_wp_http_referer'];

    foreach($fields as $field) {
      if(isset($data[$field])) {
        unset($data[$field]);
      }
    }

    // Set empty strings to false, strip tags on all else
    foreach($data as $key=>$value) {
      if($value === "") {
        $data[$key] = false;
      } else {
        $data[$key] = strip_tags($value);
      }
    }

    return $data;
  }

  /**
   * Unslash
   *
   * @param array
   *
   * @return array
   */
  private function unslashFields($data)
  {
    foreach($data as $key=>$value) {
      $data[$key] = stripslashes_deep($value);
    }
    return $data;
  }

}

if(is_admin()) {
  (new gjOptions())->loadAdmin();
}

