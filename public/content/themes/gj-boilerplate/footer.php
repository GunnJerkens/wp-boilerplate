<footer id="footer">
	<div class="container">
		<?php include('partials/register-form.php'); ?>
		<form role="form" id="rsvp">
			<p class="lead">Let the good times roll! Join us for the Grand Opening of Test Form 02, a new 55+ community in the greater Bay Area. Enjoy live classic rock music, a classic car collection on display and tasty burgers, beer and wine&mdash;plus tour the brand new model homes and resort-style amenities to see what this amazing gated community is all about!</p>
			<input type="text" class="hidden" name="gjForm" value="230">
  		<input type="text" class="hidden" name="jetstashForm" value="vvPXx23njGE7">
			<p class="lead big">SATURDAY, OCTOBER 26  |  12 – 3PM</p>
			<p class="lead"><span>COLLECTIVE COMMUNITY PARK</span><br/><strong>933 E. Louise Ave. Manteca, CA 95336</strong></p>
			<input type="text" class="hidden" name="type" value="rsvp-event-1">
			<div class="form-group">
					<label for="first_name" class="sr-only">First Name</label>
					<input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name*" aria-labelledby="register first_name" required>
			</div>
			<div class="form-group">
					<label for="last_name" class="sr-only">Last Name</label>
					<input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name*" aria-labelledby="register last_name" required>
			</div>
			<div class="form-group">
					<label for="email" class="sr-only">Email</label>
					<input type="email" id="email" class="form-control" name="email" placeholder="Email Address*" aria-labelledby="register email" required>
			</div>
			<div class="form-group">
					<label for="phone" class="sr-only">Phone</label>
					<input type="tel" id="phone" class="form-control" name="phone" placeholder="Phone*" aria-labelledby="register phone" required>
			</div>
			<div class="form-group">
					<label for="zip" class="sr-only">Zip Code</label>
					<input type="text" id="zip" class="form-control" name="zip" placeholder="zip code*" aria-labelledby="register zip" required>
			</div>
			<div class="form-group">
				<label for="guests" class="sr-only">Are you bringing guests?*</label>
				<select id="guests" class="form-control" name="guests" required>
					<option value="" selected disabled>Are you bringing guests?*</option>
					<option value="1">It's Just Me</option>
					<option value="2">1 guest</option>
					<option value="3">2 guests</option>
					<option value="4">3 guests</option>
					<option value="5">4 guests</option>
					<option value="6">5 guests</option>
				</select>
			</div>
			<p class="required-fields">*Required Field</p>
			<div id="error"></div>
			<button type="submit" id="submit">RSVP TO RESERVE YOUR SPOT TODAY ></button>
			<p class="thanks">See you at the event!</p>
		</form>
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

<div id="cookie-popup">
	<div class="cookie-popup-content">
		<button class="cookie-popup-close">X</button>
		<div class="cookie-popup-inner">
			<p>We use cookies to personalize content and ads, to provide social media features and to analyze our traffic. We also share information about your use of our site with our social media, advertising and analytics partners. By using this website you agree to the usage of these cookies. For more information about how we use cookies, visit our <a href="#">Privacy Policy</a>.</p>
		</div>
	</div>
</div>

</body>
</html>