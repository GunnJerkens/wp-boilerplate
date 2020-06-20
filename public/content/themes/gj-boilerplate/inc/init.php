<?php

/**
 * gj-boilerplate init class
 *
 * @since 2.3.0
 */

class gjInit
{

  /**
   * Private class vars
   *
   * @var $environment
   */
  private $environment, $gjOptions;

  /**
   * Class constructor
   */
  function __construct()
  {
    $this->environment = constant('WP_ENV');
    $this->gjOptions   = get_option('gj_options') ? json_decode(get_option('gj_options')) : false;

    $this->load();
  }

  /**
   * Loads the hooks
   *
   * @return void
   */
  private function load()
  {
    // Define upload_url_path to embed media with domain-relative URLs
    update_option('upload_url_path', '/shared');

    // Removes manifest/rsd/shortlink from wp_head
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    // Adds post thumbnails to theme
    add_theme_support( 'post-thumbnails' );

    // Loads google tag manager
    add_action('gtm_head', array(&$this, 'loadGoogleTagManagerHead'));
    add_action('gtm_body', array(&$this, 'loadGoogleTagManagerBody'));

    // Password protect
    add_action ('template_redirect', array(&$this, 'passwordProtect'));

    // Register menus && remove menu ul
    $this->registerMenus();
    add_filter('wp_nav_menu', array(&$this, 'removeMenuUl'));

    // Creates custom post types
    add_action( 'init', array(&$this, 'createPostType') );

    // Creates custom taxonomies
    add_action( 'init', array(&$this, 'createTaxonomy') );
  }

  /**
   * Registers menus
   *
   * @return void
   */
  public function registerMenus()
  {
    register_nav_menus(array(
      'main' => 'Main Navigation'
    ));
  }

  /**
   * Registers custom post types
   *
   * @return void
   */
  public function createPostType()
  {
    register_post_type('MPCs', array(
      'labels' => array(
        'name' => __('MPCs'),
        'singular_name' => __('MPC'),
        'add_new_item'  => 'Add New MPC',
        'new_item_name' => 'New MPC'
        ),
      'menu_icon'       => 'dashicons-admin-multisite',
      'public'          => true,
      'hierarchical'    => true,
      'show_in_rest'    => true,
      'rest_base'       => 'mpcs',
      'supports'        => array('title','editor','thumbnail','author','page-attributes')
    ));

    register_post_type('Communities', array(
      'labels' => array(
        'name' => __('Communities'),
        'singular_name' => __('Community'),
        'add_new_item'  => 'Add New Community',
        'new_item_name' => 'New Community'
        ),
      'menu_icon'       => 'dashicons-admin-multisite',
      'public'          => true,
      'hierarchical'    => true,
      'show_in_rest'    => true,
      'rest_base'       => 'communities',
      'supports'        => array('title','editor','thumbnail','author','page-attributes')
    ));

    register_post_type('Plans', array(
      'labels' => array(
        'name' => __('Plans'),
        'singular_name' => __('Plan'),
        'add_new_item'  => 'Add New Plan',
        'new_item_name' => 'New Plan'
        ),
      'menu_icon'       => 'dashicons-admin-multisite',
      'public'          => true,
      'hierarchical'    => true,
      'show_in_rest'    => true,
      'rest_base'       => 'plans',
      'supports'        => array('title','editor','thumbnail','author','page-attributes')
    ));

    register_post_type('QMIs', array(
      'labels' => array(
        'name' => __('QMIs'),
        'singular_name' => __('QMI'),
        'add_new_item'  => 'Add New QMI',
        'new_item_name' => 'New QMI'
        ),
      'menu_icon'       => 'dashicons-admin-multisite',
      'public'          => true,
      'hierarchical'    => true,
      'show_in_rest'    => true,
      'rest_base'       => 'qmis',
      'supports'        => array('title','editor','thumbnail','author','page-attributes')
    ));
  }

  /**
   * Registers custom taxonomy
   *
   * @return void
   */
  function createTaxonomy() {

    $labels = array(
      'name'              => _x( 'Regions', 'taxonomy general name', 'textdomain' ),
      'singular_name'     => _x( 'Region', 'taxonomy singular name', 'textdomain' ),
      'search_items'      => __( 'Search Regions', 'textdomain' ),
      'all_items'         => __( 'All Regions', 'textdomain' ),
      'parent_item'       => __( 'Parent Region', 'textdomain' ),
      'parent_item_colon' => __( 'Parent Region:', 'textdomain' ),
      'edit_item'         => __( 'Edit Region', 'textdomain' ),
      'update_item'       => __( 'Update Region', 'textdomain' ),
      'add_new_item'      => __( 'Add New Region', 'textdomain' ),
      'new_item_name'     => __( 'New Region Name', 'textdomain' ),
      'menu_name'         => __( 'Regions', 'textdomain' ),
    );

    $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array('slug' => false, 'with_front' => false),
    );

    register_taxonomy( 'regions', array( 'post' ), $args );

    // register_taxonomy(
    //   'region',
    //   array('regions'),
    //   array(
    //       'labels' => array(
    //           'name' => 'Region',
    //           'add_new_item' => 'Add Region',
    //           'new_item_name' => 'New Region'
    //       ),
    //       'show_ui' => true,
    //       'show_in_menu' => true,
    //       'show_tagcloud' => false,
    //       'rewrite' => array(
    //         'slug' => false,
    //         'with_front' => false
    //       ),
    //       'hierarchical' => true
    //   )
    // );
  }

  /**
   * Loads Google Tag Manager Head
   *
   * @return void
   */
  public function loadGoogleTagManagerHead()
  {
    if($this->environment === "production" && isset($this->gjOptions->google_tag_manager) && $this->gjOptions->google_tag_manager) {
      echo "
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','" .$this->gjOptions->google_tag_manager. "');</script>
        <!-- End Google Tag Manager -->
      ";
    }
  }

  /**
   * Loads Google Tag Manager Body
   *
   * @return void
   */
  public function loadGoogleTagManagerBody()
  {
    if($this->environment === "production" && isset($this->gjOptions->google_tag_manager) && $this->gjOptions->google_tag_manager) {
      echo '
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$this->gjOptions->google_tag_manager.'"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
      ';
    }
  }

  /**
   * Password protects environments
   *
   * @return void
   */
  public function passwordProtect()
  {
    if(WP_PASSWORD_PROTECT == true) {
      if(!is_user_logged_in()) {
        auth_redirect();
      }
    }
  }

  /**
   * Removes <ul> wrapper from wp_nav_menu functions
   *
   * @return string
   */
  public function removeMenuUl($menu)
  {
    return preg_replace(array('#^<ul[^>]*>#', '#</ul>$#' ), '', $menu);
  }

}

new gjInit();
