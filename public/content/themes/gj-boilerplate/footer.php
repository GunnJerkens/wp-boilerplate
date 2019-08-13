<footer id="footer">
	<div class="container">
    <ul class="footer-links">
      <li class="footer-link"><a href="/register">Register</a></li>
      <li class="footer-link"><a href="#" class="modal-trigger" data-open-modal="privacy">Privacy</a></li>
    </ul>
	</div>
</footer>
<div id="modal-overlay"></div>

<aside id="privacy" class="modal">
  <div class="modal-inner">
    <a role="button" href="#" class="modal-close" aria-label="close modal">
      <svg class="icon-close"><use xlink:href="#close"></use></svg>
    </a>
    <h1 class="modal-title">Privacy Policy</h1>
    <div class="modal-content">
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    </div>
  </div>
</aside>

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