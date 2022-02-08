<?php
/**
 * Plugin Name:       Forumone Test
 * Description:       Example block created using NYT Books API.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       forumone-test
 *
 * @package           create-block
 */


namespace ForumOneExampleBlock;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


//Pull in Admin setup
require_once( dirname( __FILE__ ) . '/inc/admin.php' );


//Pull in rest route setup
require_once( dirname( __FILE__ ) . '/inc/rest.php' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_forumone_test_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', __NAMESPACE__ . '\create_block_forumone_test_block_init' );
