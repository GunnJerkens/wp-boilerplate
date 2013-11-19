<?php

// Password protect staging environments
if( WP_PASSWORD_PROTECT == true ){

	function password_protect() {
		if ( !is_user_logged_in() ) {
			auth_redirect();
		}
	}

	add_action ('template_redirect', 'password_protect');
}

// Define upload_url_path to embed media with domain-relative URLs
// Only needs to be excuted once on project initialization
update_option('upload_url_path', '/shared');

// Loads Google Analytics
$google_analytics_id = 'UA-XXXXXXXX-X'; // override this value in functions.php
function google_analytics() {
		global $env_default, $google_analytics_id;
		$default_hostname = preg_replace('/^https?:\/\//', '', $env_default['hostname']);
		?>
		<!-- Google Analytics -->
		<script type="text/javascript">
		if(['<?php echo $default_hostname ?>','www.<?php echo $default_hostname ?>']
			 .indexOf(window.location.hostname) > -1
			 && window.location.search.search('&preview=true') == -1
		) {
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics_id ?>']);
		_gaq.push(['_setDomainName', '<?php echo $default_hostname ?>']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();}
		</script>
<?php
} // google_analytics
add_action('wp_head','google_analytics');

// Removes manifest/rsd/shortlink from wp_head
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

// Adds post thumbnails to theme
add_theme_support( 'post-thumbnails' );

// Removes ul class from wp_nav_menu
function remove_ul ( $menu ){
    return preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
}
add_filter( 'wp_nav_menu', 'remove_ul' );
