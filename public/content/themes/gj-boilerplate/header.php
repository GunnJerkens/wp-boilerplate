<!DOCTYPE html>
<html lang="en">
<head>
  <?php do_action('gtm_head'); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon.png"/>
  <title><?php wp_title('|'); ?></title>
  <?php wp_head(); ?>
  <!-- Menu Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="menu-defs" class="hide-defs">
    <defs>
      <symbol id="menu" viewBox="0 0 24 24">
        <title>menu</title>
        <path d="M3,6h18v1.6H3V6z M3,12.8v-1.6h18v1.6H3z M3,18v-1.6h18V18H3z"/>
      </symbol>
    </defs>
  </svg>
  <!-- Close Icon -->
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
  <header id="header">
    <div class="container">
      <a class="logo" href="/">
        <img id="linkTop" src="<?php bloginfo('template_directory');?>/img/logo.png" width="277" alt="Pickle in a slingshot">
      </a>
      <nav id="main-nav" role="navigation">
        <ul class="nav-list">
          <?php wp_nav_menu(array('menu' => 'Main', 'container' => false)); ?>
        </ul>
      </nav>
      <button type="button" id="navbar-toggle" aria-expanded="false">
        <svg class="icon-menu"><use xlink:href="#menu"></use></svg>
      </button>
      <div id="header-cta">
        <a class="nav-list-link" id="linkList" href="#getOnTheList">Get On The List
          <svg class="icon-chevron"><use xlink:href="#chevron-right"></use></svg>
        </a>
      </div>
    </div>
  </header>
