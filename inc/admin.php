<?php

//file used to set up settings in amdmin dashboard
namespace BBuildsNYTBlock\admin;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//add menu page
//https://developer.wordpress.org/reference/functions/add_menu_page/
add_action( 'admin_menu', __NAMESPACE__ . '\create_menu_page' );

function create_menu_page() {
	add_menu_page(
		__( 'NYT Book Block Block Settings', 'bbuilds-nyt-block' ),
		__( 'NYT Book Block Settings', 'bbuilds-nyt-block' ),
		'manage_options',
		'bbuilds-nyt-block-settings',
		__NAMESPACE__ . '\plugin_options_page',
		'dashicons-hammer',
		25
	);
}

//creating the plugin page callback function
function plugin_options_page() { ?>
	<div>
		<form action="options.php" method="post">
			<?php settings_fields('bbuilds_nyt_demo_plugin_options'); ?>
			<?php do_settings_sections('bbuilds-nyt-books-demo-plugin'); ?>
			<input name="Submit" type="submit" value="<?php _e('Save Changes', 'bbuilds-nyt-block'); ?>" />
		</form>
	</div>

<?php }

//creating the settings
add_action('admin_init', __NAMESPACE__ . '\plugin_admin_init');

function plugin_admin_init(){
	//https://developer.wordpress.org/reference/functions/register_setting/
	register_setting( 'bbuilds_nyt_demo_plugin_options', 'bbuilds_nyt_demo_plugin_options', __NAMESPACE__ . '\plugin_options_validate' );

	//https://developer.wordpress.org/reference/functions/add_settings_section/
	add_settings_section('plugin_main', 'API URL Settings', __NAMESPACE__ . '\plugin_section_text', 'bbuilds-nyt-books-demo-plugin');

	//https://developer.wordpress.org/reference/functions/add_settings_field/
	add_settings_field('plugin_text_string', 'Enter URL:', __NAMESPACE__ . '\plugin_setting_string', 'bbuilds-nyt-books-demo-plugin', 'plugin_main');
}

//arbituary info text callback

function plugin_section_text() {
	echo '<p>'. __('Enter an API URL to display the four most recent records.', 'bbuilds-nyt-block') .'</p>';
	echo '<p>'. __('I\'m currently using <a href="https://developer.nytimes.com/docs/books-product/1/routes/lists.json/get" target="_blank">https://developer.nytimes.com/docs/books-product/1/routes/lists.json/get</a>', 'bbuilds-nyt-block') .'</p>';
}

//add_settings_field callback to display field
function plugin_setting_string() {
	$url = get_option('bbuilds_nyt_demo_plugin_options');
	echo "<input id='plugin_text_string' name='bbuilds_nyt_demo_plugin_options[text_string]' type='text' value='{$url}' />";
}

//validating | sanitizing URL input
function plugin_options_validate($input) {
	$newinput['text_string'] = trim($input['text_string']);
	return filter_var( $newinput['text_string'], FILTER_VALIDATE_URL );
}
