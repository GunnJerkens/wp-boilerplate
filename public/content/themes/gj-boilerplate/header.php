<!DOCTYPE html>
<html class="no-js">
<head>
  <?php do_action('gtm_head'); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php wp_title('|'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php do_action('gtm_body'); ?>
