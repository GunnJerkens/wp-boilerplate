<form role="form" id="register">
  <p class="lead">Sign up to receive news and announcements about <strong>Test Form 01</strong>.</p>
  <input type="text" class="hidden" name="gjForm" value="229">
  <input type="text" class="hidden" name="jetstashForm" value="p7chxfrmWHkx">
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
      <input type="tel" id="phone" class="form-control" name="phone" placeholder="Phone" aria-labelledby="register phone">
  </div>
  <div class="form-group">
      <label for="zip" class="sr-only">Zip</label>
      <input type="text" id="zip" class="form-control" name="zip" placeholder="Zip*" aria-labelledby="register zip" required>
  </div>
  <div class="form-group">
    <label for="i_am_a" class="sr-only">I am a:*</label>
    <select id="i_am_a" class="form-control" name="i_am_a" required>
      <!-- <option value="I Am A">I Am A:*</option> -->
      <option value="" selected disabled>I am a:*</option>
      <option value="Homeowner">Homeowner</option>
      <option value="Broker">Broker</option>
      <option value="Homeowner with Broker">Homeowner with Broker</option>
    </select>
  </div>

  <?php if ( is_user_logged_in() ) { // Show the Facebook Lead Gen option for logged in users, so we can manually add Lead Gen leads ?>
    <div class="form-group">
        <label for="source">IS THIS A FB LEAD GEN?</label> &nbsp; <input type="checkbox" id="source" class="form-control" name="source" value="FB Lead Gen">
        <br/><br/>
    </div>
  <?php } ?>


  <p class="required-fields">*Required Field</p>
  <div id="error"></div>
  <button type="submit" id="submit">Submit</button>
  <p class="thanks">Thank you, we'll be in touch soon.</p>
</form>
