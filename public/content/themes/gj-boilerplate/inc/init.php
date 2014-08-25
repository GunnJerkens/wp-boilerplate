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
    $google_analytics_id = get_option('gj_options_ga') ? get_option('gj_options_ga') : 'UA-XXXXXXXX-X';
    $default_hostname = preg_replace('/^https?:\/\//', '', $env_default['hostname']); ?>

    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php echo $google_analytics_id ?>', '<?php echo $default_hostname ?>');
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
      <script type=\'text/javascript\'>//<![CDATA[
      document.write("<script async src=\'//HOST:3000/browser-sync-client.1.3.6.js\'><\/script>".replace(/HOST/g, location.hostname));
      //]]></script>'
    ;
  }
  add_action('wp_footer','add_browser_sync');
}

// Sets up ACF for titles
if(function_exists("register_field_group")) {
  register_field_group(array (
    'id' => 'acf_title',
    'title' => 'theTitle()',
    'fields' => array (
      array (
        'key' => 'field_533db25105c50',
        'label' => 'Title Type',
        'name' => 'title_type',
        'type' => 'select',
        'instructions' => 'Use text or an image as a page title, none defaults to the WordPress the_title() function.',
        'choices' => array (
          'none' => 'None',
          'text' => 'Text',
          'image' => 'Image',
        ),
        'default_value' => '',
        'allow_null' => 0,
        'multiple' => 0,
      ),
      array (
        'key' => 'field_533db2e305c51',
        'label' => 'Title Text',
        'name' => 'title_text',
        'type' => 'text',
        'conditional_logic' => array (
          'status' => 1,
          'rules' => array (
            array (
              'field' => 'field_533db25105c50',
              'operator' => '==',
              'value' => 'text',
            ),
          ),
          'allorany' => 'all',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_533db32131385',
        'label' => 'Title Image',
        'name' => 'title_image',
        'type' => 'image',
        'conditional_logic' => array (
          'status' => 1,
          'rules' => array (
            array (
              'field' => 'field_533db25105c50',
              'operator' => '==',
              'value' => 'image',
            ),
          ),
          'allorany' => 'all',
        ),
        'save_format' => 'object',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'default',
      'hide_on_screen' => array (
      ),
    ),
    'menu_order' => 0,
  ));
}
