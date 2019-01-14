<!DOCTYPE html>
<html>
  <head>
    <?php do_action('gtm_head'); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|'); ?></title>
    <?php wp_head(); ?>

    <!-- Reusable SVG elements - use class hide-defs so defs don't display -->

    <!-- CLOSE ICON for modal -->
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="close-defs" class="hide-defs">
      <defs>
        <symbol id="close" viewBox="0 0 35 35">
          <title>close</title>
          <rect x="-6.82" y="17.07" width="48.63" height="0.86" transform="translate(17.5 -7.25) rotate(45)"/>
          <rect x="-6.82" y="17.07" width="48.63" height="0.86" transform="translate(42.25 17.5) rotate(135)"/>
        </symbol>
      </defs>
    </svg>

  </head>
  <body <?php body_class(); ?>>
    <?php do_action('gtm_body'); ?>
