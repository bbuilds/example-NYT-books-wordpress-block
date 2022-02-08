<?php

//file used to set up settings in amdmin dashboard
namespace ForumOneExampleBlock\admin;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//add menu page
//https://developer.wordpress.org/reference/functions/add_menu_page/
add_action( 'admin_menu', __NAMESPACE__ . '\create_menu_page' );

function create_menu_page() {
	add_menu_page(
		__( 'Forum One Block Settings', 'forumone-test' ),
		__( 'Forum One Settings', 'forumone-test' ),
		'manage_options',
		'forumone-test-settings',
		__NAMESPACE__ . '\plugin_options_page',
		'dashicons-hammer',
		25
	);
}

//creating the plugin page callback function
function plugin_options_page() { ?>
	<div>
		<form action="options.php" method="post">
			<?php settings_fields('forum_one_plugin_options'); ?>
			<?php do_settings_sections('forum-one-api-plugin'); ?>
			<input name="Submit" type="submit" value="<?php _e('Save Changes', 'forumone-test'); ?>" />
		</form>
	</div>

<?php }

//creating the settings
add_action('admin_init', __NAMESPACE__ . '\plugin_admin_init');

function plugin_admin_init(){
	//https://developer.wordpress.org/reference/functions/register_setting/
	register_setting( 'forum_one_plugin_options', 'forum_one_plugin_options', __NAMESPACE__ . '\plugin_options_validate' );

	//https://developer.wordpress.org/reference/functions/add_settings_section/
	add_settings_section('plugin_main', 'API URL Settings', __NAMESPACE__ . '\plugin_section_text', 'forum-one-api-plugin');

	//https://developer.wordpress.org/reference/functions/add_settings_field/
	add_settings_field('plugin_text_string', 'Enter URL:', __NAMESPACE__ . '\plugin_setting_string', 'forum-one-api-plugin', 'plugin_main');
}

//arbituary info text callback

function plugin_section_text() {
	echo '<p>'. __('Enter an API URL to display the four most recent records.', 'forumone-test') .'</p>';
	echo '<p>'. __('I\'m currently using <a href="https://developer.nytimes.com/docs/books-product/1/routes/lists.json/get" target="_blank">https://developer.nytimes.com/docs/books-product/1/routes/lists.json/get</a>', 'forumone-test') .'</p>';
}

//add_settings_field callback to display field
function plugin_setting_string() {
	$url = get_option('forum_one_plugin_options');
	echo "<input id='plugin_text_string' name='forum_one_plugin_options[text_string]' type='text' value='{$url}' />";
}

//validating | sanitizing URL input
function plugin_options_validate($input) {
	$newinput['text_string'] = trim($input['text_string']);
	return filter_var( $newinput['text_string'], FILTER_VALIDATE_URL );
}
