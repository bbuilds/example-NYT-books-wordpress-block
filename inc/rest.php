<?php

namespace BBuildsNYTBlock\rest;

use WP_REST_Response;
use WP_Error;
use WP_REST_Server;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


//Creating Rest Endpoint to proxy and save for easier dev | secruity
//https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
add_action( 'rest_api_init',  __NAMESPACE__ . '\create_block_rest_route');
function create_block_rest_route() {
	register_rest_route( 'bbuilds/v1', '/nyt/', array(
		'methods'             => WP_REST_Server::READABLE,
		'callback'            => __NAMESPACE__ . '\proxy_requests',
	) );
}

// proxy grab data to get around CORS local dev
function proxy_requests( $data ) {
	$api_url = get_option('bbuilds_nyt_demo_plugin_options');

	$api_response = wp_remote_get($api_url);
	if ( empty( $api_response ) || 200 !== $api_response['response']['code'] ) {
		return new WP_Error(
			'error',
			[
				'input'    => $data,
				'response' => $api_response,
			]
		);
	}
	return new WP_REST_Response( json_decode( $api_response['body'] ) );
}
