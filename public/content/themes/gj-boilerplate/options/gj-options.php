<h2>Site Options</h2><?php

$gjOptions = new gjOptions();

if(isset($_POST['gj_hidden']) && $_POST['gj_hidden'] == 'gj_options') {
  if(1 !== check_admin_referer('gj-options')) {
    die('Permission denied.');
  }

  $options = $gjOptions->updateOptions($_POST);

  echo '<div class="updated"><p><strong>Options saved.</strong></p></div>';

} else {

  $options = $gjOptions->requestOptions();

} ?>

<style>
  input, textarea {
    min-width: 350px;
  }
  button.btn {
    width: auto;
    margin-top: 15px;
  }
</style>

<form name="gj_form_update_options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
  <input type="hidden" name="gj_hidden" value="gj_options">
  <?php wp_nonce_field('gj-options'); ?>
  <table class="form-table">
    <tr>
      <th><label for="google_analytics">Google Tag Manager Container ID</label></th>
      <td><input id="google_tag_manager" type="text" name="google_tag_manager" value="<?php echo $options && isset($options->google_tag_manager) ? $options->google_tag_manager : ''; ?>"></td>
    </tr>
    <tr>
      <th><label for="google_meta">Google Meta</label></th>
      <td><input id="google_meta" type="text" name="google_meta" value="<?php echo $options && isset($options->google_meta) ? $options->google_meta : ''; ?>"></td>
    </tr>
    <tr>
      <th><label for="facebook">Facebook</label></th>
      <td><input id="facebook" type="text" name="facebook" value="<?php echo $options && isset($options->facebook) ? $options->facebook : ''; ?>"></td>
    </tr>
    <tr>
      <th><label for="twitter">Twitter</label></th>
      <td><input id="twitter" type="text" name="twitter" value="<?php echo $options && isset($options->twitter) ? $options->twitter : ''; ?>"></td>
    </tr>
    <tr>
      <th><label for="instagram">Instagram</label></th>
      <td><input id="instagram" type="text" name="instagram" value="<?php echo $options && isset($options->instagram) ? $options->instagram : ''; ?>"></td>
    </tr>
  </table>
  <button class="btn button" type="submit">Update Options</button>
</form>
