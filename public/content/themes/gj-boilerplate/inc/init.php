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
  private $environment;

  /**
   * Class constructor
   */
  function __construct()
  {
    $this->environment = constant('WP_ENV');

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

    // Loads google analytics & webmaster verification
    add_action('wp_head', array(&$this, 'loadGoogleAnalytics'));
    add_action('wp_head', array(&$this, 'loadGoogleMeta'));

    // Password protect
    add_action ('template_redirect', array(&$this, 'passwordProtect'));

    // Load browser sync
    add_action('wp_footer', array(&$this, 'loadBrowserSync'));

    // Remove menu ul
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
   * Loads Google Analytics
   *
   * @return void
   */
  public function loadGoogleAnalytics()
  {
    $analyticsId = get_option('gj_options_ga') ? get_option('gj_options_ga') : false;

    if($this->environment === "production" && $analyticsId) {
      echo "
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '".$analyticsId."', 'auto');
          ga('require', 'displayfeatures');
          ga('send', 'pageview');
        </script>
      ";
    }
  }

  /**
   * Loads webmaster tools meta verification tag
   *
   * @return void
   */
  public function loadGoogleMeta()
  {
    $metaTag = get_option('gj_options_meta') ? get_option('gj_options_meta') : false;

    if($this->environment === "production" && $metaTag) {
      echo '<meta name="google-site-verification" content="'.$metaTag.'">';
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
            document.write("<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.2.6.4.js\'><\/script>".replace("HOST", location.hostname));
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
