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