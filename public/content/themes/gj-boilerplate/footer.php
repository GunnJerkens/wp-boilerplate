

<?php wp_footer(); ?>

<!-- POPUP start -->
<?php if (get_field('enable_popup', $post->ID)) {
	$popup_image = get_field('popup_image', $post->ID);
	$popup_link = get_field('popup_link', $post->ID);
	$popup_new_tab = get_field('popup_new_tab', $post->ID); ?>
<div id="popup" class="popup-container">
  <div class="popup-content">
    <div class="popup-inner">
			<?php if($popup_link) { ?>
      <a class="popup-link" href="<?php echo $popup_link; ?>"<?php echo $popup_new_tab ? ' target="_blank"' : ''; ?>>
			<?php } ?>
      <img src="<?php echo $popup_image['url']; ?>" alt="<?php echo $popup_image['alt']; ?>">
			<?php if($popup_link !== '') { ?>
			</a>
			<?php } ?>
    </div>
  </div>
  <div class="popup-overlay">
  </div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		function loadPopup() {
			$('#popup').fadeIn(600);
			$('body').addClass('no-scroll');
			$('#popup').on('click touchstart', function(e){
				$('#popup').fadeOut(600);
				$('body').removeClass('no-scroll');
			});
		}
		loadPopup();
	});

</script>
<?php } ?>
<!-- POPUP end -->

</body>
</html>