<?php
/*
*
* Content functions that can be used around the site, theTitle();
* depends on having ACF installed so that helper function in init
* can run.
*
*/

// Page Titles
function theTitle() {

  echo '<div class="container"><h1 class="page-title">';

  if (get_field('title_type') === 'text') {
    $subTitle = get_field('title_text');
    echo $subTitle;
  } elseif (get_field('title_type') === 'image' ) {
    $titleImage = get_field('title_image');
    echo '<img src="'.$titleImage['url'].'" alt="'.$titleImage['alt'].'">';
  } else {
    $defaultTitle = get_the_title();
    echo $defaultTitle;
  }

  echo '</h1></div>';

}

// Default loop content not found
function theMissing() {
  $missing = '
    <article class="the-missing">
      <h2><span>Not Found</span></h2>
      <p>Sorry, but the content you\'re looking for is not here.</p>
    </article>';
  echo $missing;
}