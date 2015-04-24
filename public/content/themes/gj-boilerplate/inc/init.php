<?php

// Define upload_url_path to embed media with domain-relative URLs
// Only needs to be excuted once on project initialization
update_option('upload_url_path', '/shared');

// Password protect staging environments
if( WP_PASSWORD_PROTECT == true ){

  function password_protect() {
    if ( !is_user_logged_in() ) {
      auth_redirect();
    }
  }

  add_action ('template_redirect', 'password_protect');
}

if(constant('WP_ENV') === 'production') {

  // Loads Google Analytics
  function google_analytics() {

    global $env_default;
    $google_analytics_id = get_option('gj_options_ga') ? get_option('gj_options_ga') : 'UA-XXXXXXXX-X'; ?>

    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php echo $google_analytics_id ?>', 'auto');
      ga('require', 'displayfeatures');
      ga('send', 'pageview');
    </script><?php

  }

  // Loads Google Meta Verification
  function google_meta() {

    $google_meta = get_option('gj_options_meta') ? get_option('gj_options_meta') : false;

    if($google_meta) {
      echo '<meta name="google-site-verification" content="'.$google_meta.'">';
    }

  }

  add_action('wp_head','google_analytics');
  add_action('wp_head','google_meta');

}

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

// Navigation Menu Array
register_nav_menus(
  array(
    'main' => 'Main Navigation'
  )
);

// Removes ul class from wp_nav_menu
function remove_ul($menu) {
  return preg_replace(array('#^<ul[^>]*>#', '#</ul>$#' ), '', $menu);
}
add_filter('wp_nav_menu', 'remove_ul');

// Add socket.io snippet to enable Browser Sync
if(constant('WP_ENV') == 'local') {
  function add_browser_sync() {
    echo '
      <script type=\'text/javascript\' id="__bs_script__">//<![CDATA[
          document.write("<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.2.6.4.js\'><\/script>".replace("HOST", location.hostname));
      //]]></script>
    ';
  }
  add_action('wp_footer','add_browser_sync');
}
