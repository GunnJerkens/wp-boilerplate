<h2>Site Options</h2><?php

if(isset($_POST['gj_hidden']) && $_POST['gj_hidden'] == 'gj_options') {

  $gj_options_ga = $_POST['gj_options_ga'];
  update_option('gj_options_ga', $gj_options_ga); 

  $gj_options_meta = $_POST['gj_options_meta'];
  update_option('gj_options_meta', $gj_options_meta); ?>

  <div class="updated"><p><strong>Options saved.</strong></p></div><?php

} else {

  $gj_options_ga = get_option('gj_options_ga');
  $gj_options_meta = get_option('gj_options_meta');


} ?>

<style>
  input.btn {
    width: auto;
    margin-top: 15px;
  }
</style>

<form name="gj_form_update_options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
  <input type="hidden" name="gj_hidden" value="gj_options">
  <table class="form-table">
    <tr>
      <th><label for="gj_options_ga">Google Analytics</label></th>
      <td><input id="gj_options_ga" type="text" name="gj_options_ga" value="<?php echo $gj_options_ga ? $gj_options_ga : ''; ?>"></td>
    </tr>
    <tr>
      <th><label for="gj_options_meta">Google Meta Verification</label></th>
      <td><input id="gj_options_meta" type="text" name="gj_options_meta" value="<?php echo $gj_options_meta ? $gj_options_meta : ''; ?>"></td>
    </tr>
  </table>

  <input class="btn button" type="submit" name="Submit" value="Update Settings" />

</form>
