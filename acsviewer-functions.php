<?php

if (!defined('ACSVIEWER_WP_PLUGIN_NAME'))
    define('ACSVIEWER_WP_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('ACSVIEWER_WP_PLUGIN_URL'))
{
  define('ACSVIEWER_WP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

function acsviewer_mce_addbuttons()
{
  // Permissions Check
  if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
    return;

  // Add button to TinyMCE Editor
  if ( get_user_option('rich_editing') == 'true')
  {
    add_filter("mce_external_plugins", "acsviewer_add_tinymce_plugin");
    add_filter('mce_buttons', 'acsviewer_register_mce_button');
  }
}

function acsviewer_register_mce_button($buttons)
{
  array_push($buttons, "separator", "acsviewer");
  return $buttons;
}

function acsviewer_add_tinymce_plugin($plugin_array)
{
  $plugin_array['acsviewer'] = ACSVIEWER_WP_PLUGIN_URL.'js/acsviewer-plugin.js';
  return $plugin_array;
}

function acsviewer_dialog_window()
{
  global $wp_version;
  define('JS_PLUGIN_URL', includes_url() . '/js');

  // Get ACS Viewer License Key
  $licenseKey = get_option('licenseKey');

  // Display Form
?>
<!DOCTYPE html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <title>Accusoft Cloud Services Viewer</title>
    </head>
    <body>

        <?php
             $accusoftServer = get_option('ACCUSOFT_SERVER');
             $url = 'http:';
             $url = $url . $accusoftServer .'/v1/viewer/configurator?env=wordpress&userKey='.$licenseKey;
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_HEADER, 0);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
             curl_setopt($ch, CURLOPT_URL, $url);
             $data = curl_exec($ch);
             curl_close($ch);
             echo $data;
          ?>
        <script type="text/javascript" src="<?php echo ACSVIEWER_WP_PLUGIN_URL ?>js/acsviewer-dialog.js"></script>
    </body>
</html>

<?php exit();

}
