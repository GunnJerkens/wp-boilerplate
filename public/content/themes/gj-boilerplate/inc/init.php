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

    // Load browser sync
    add_action('wp_footer', array(&$this, 'loadBrowserSync'));

    // Register menus && remove menu ul
    $this->registerMenus();
    add_filter('wp_nav_menu', array(&$this, 'removeMenuUl'));
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
   * Loads browser sync
   *
   * @return void
   */
  public function loadBrowserSync()
  {
    if($this->environment === "local") {
      echo '
        <script type=\'text/javascript\' id="__bs_script__">//<![CDATA[
          document.write("<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.2.13.0.js\'><\/script>".replace("HOST", location.hostname));
        //]]></script>
      ';
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
