<?php
/*
*
* Content functions that can be used around the site, 
*
*/

// Default loop content not found
function theMissing()
{
  echo '
    <article class="the-missing">
      <h2><span>Not Found</span></h2>
      <p>Sorry, but the content you\'re looking for is not here.</p>
    </article>
  ';
}

/* Responsive image */
function respImg($sizes, $name, $class, $alt, $ext) {
  $count = count($sizes)-1;
  $lastSize = $sizes[$count]+1;
  $path = get_template_directory_uri();

  echo '<picture>';
    foreach ($sizes as $key => $size) {
      echo '<source media="(max-width: '.$size.'px)" srcset="'.$path.'/img/webp/'.$name.'-'.$size.'.webp" type="image/webp">';
      echo '<source media="(max-width: '.$size.'px)" srcset="'.$path.'/img/'.$name.'-'.$size.'.'.$ext.'" type="image/'.$ext.'">';
    }
    echo '<source media="(min-width: '.$lastSize.'px)" srcset="'.$path.'/img/webp/'.$name.'.webp" type="image/webp">';
    echo '<img class="'.$class.'" src="'.$path.'/img/'.$name.'.'.$ext.'" alt="'.$alt.'">';
  echo '</picture>';
}

/* Neighborhoods and/or residences ranges */

function calculate_range_sqft($values) {

  // Drop all empty string values. If there's any values remaining, find min/max. Else set to empty string.
  $min = (count($values) > 0) ? min($values) : '';
  $max = (count($values) > 0) ? max($values) : '';
  $return = '';
  if ($min == '' || $max == '') {
    $return .= number_format($min).number_format($max);
  } else {
    $return .= number_format($min);
    if ($min != $max) $return .= ' – '.number_format($max);
  }
  return $return;
}

function calculate_range($values) {

  // Drop all empty string values. If there's any values remaining, find min/max. Else set to empty string.
  $min = (count($values) > 0) ? min($values) : '';
  $max = (count($values) > 0) ? max($values) : '';
  $return = '';
  if ($min == '' || $max == '') {
    $return .= $min.$max;
  } else {
    $return .= $min;
    if ($min != $max) $return .= ' – '.$max;
  }
  return $return;
}

/* Blog */

// Handle the post excerpt at a set char count
function get_excerpt($count = 230){
  global $post;
  $excerpt = get_the_content($post->ID);
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = $excerpt;
  return $excerpt;
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="btn load-posts"';
}

function filter_post_link($link) {
  $link = str_replace("rel=", 'class="btn mx-md-3 mb-3 mb-md-0" rel=', $link);
  return $link;
}
add_filter('next_post_link', 'filter_post_link');

add_filter('previous_post_link', 'filter_post_link');
