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
  <?php include('partials/svg-icons.php'); ?>
</head>
<body <?php body_class(); ?>>
  <?php do_action('gtm_body'); ?>
  <header id="header">
    <div class="container">

      <!-- non-bootstrap header -->
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
      <!-- end non-bootstrap header -->
      
    </div>
  </header>
