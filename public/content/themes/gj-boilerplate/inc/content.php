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