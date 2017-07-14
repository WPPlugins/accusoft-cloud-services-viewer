<?php
	//  If the user does not have the required permissions...
    if (!current_user_can('manage_options'))
	{
		wp_die( __('You do not have sufficient permissions to access this page.') );
    }
	
	// Collect ACS Viewer settings from Database
	$licenseKey = get_option('licenseKey');

	// if (!ACCUSOFT_SERVER) { }

	add_option('ACCUSOFT_SERVER', 'Undefined');
  get_option('ACCUSOFT_SERVER');
    // Save ACS Viewer settings
    if( isset($_POST['acsviewer_settings_update']) && $_POST['acsviewer_settings_update'] == 1)
	{
		$licenseKey = trim($_POST['licenseKey']);
		update_option( 'licenseKey', $licenseKey);

        // Display an 'updated' message.
		?>
		<div class="updated"><p><strong><?php _e('Settings saved!', 'menu-test' ); ?></strong></p></div>
		<?php
	}
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br/></div>
	<h2>ACS Viewer - Document Viewer</h2>
	
	<form name="form" method="post" action="">
	<input type="hidden" name="acsviewer_settings_update" value="1">
	
<?php if(empty($licenseKey)) { ?>
  <p>In order to use ACS Viewer, the Document Viewer, you'll need to first get a license key.  Don't worry - it's completely free!  You can get your key here: <a href="https://cloudportal.accusoft.com/?type=viewer" target="_blank">https://cloudportal.accusoft.com/?type=viewer</a>.</p>
  <p>Once your sign up is complete, enter your key in the box below.</p>
<?php } else { ?>
  <p>You have entered your key. If you need to change your key, <a href="https://cloudportal.accusoft.com/?type=viewer" target="_blank">visit your account</a>.</p>
<?php } ?>
	
	<h3>Settings</h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="selectRegion">Region:</label></th>
				<td>
					<select name="selectRegion">
					  <option id="US" value="US" <?php echo !empty($_POST['selectRegion']) &&  $_POST['selectRegion'] === "US" ? "selected" : ""; ?>>US</options>
						<option id="EU" value="Europe" <?php echo !empty($_POST['selectRegion']) &&  $_POST['selectRegion'] === "Europe" ? "selected" : ""; ?>>Europe</options>
				</select>
			</tr>
			<tr>
				<th><label for="licenseKey">Key:</label></th>
				<td><input name="licenseKey" id="licenseKey" type="text" value="<?php echo $licenseKey; ?>" class="regular-text code"></td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table>
	
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes')?>" onclick="valudate()" />
	</p>

	</form>
</div>

<?php
if(isset($_POST['Submit'])) {
	if ($_POST['selectRegion'] === 'US') {
		update_option( 'ACCUSOFT_SERVER', '//dev-api.accusoft.com');
	} else if ($_POST['selectRegion'] === 'Europe'){
		update_option( 'ACCUSOFT_SERVER', '//dev-api.accusoft.eu');
	}
}

?>
