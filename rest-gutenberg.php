<?php

/*
Plugin Name: REST Gutenberg
Version: 1.0
Description: Adds a key and gutenberg block scehma within the WordPress REST API.
Author: Scott Foster
Author URI: https://www.scottfoster.dev
*/

add_action(
	'rest_api_init',
	function ( )
	{

		if ( ! function_exists( 'use_block_editor_for_post_type' ) )
		{
			require ABSPATH . 'wp-admin/includes/post.php';
		}

		$key_name = 'blocks';
		$post_types = get_post_types_by_support( [ 'editor' ] );
		foreach ( $post_types as $post_type )
		{
			if ( use_block_editor_for_post_type( $post_type ) )
			{
				register_rest_field(
					$post_type,
					$key_name,
					[
						'get_callback' => function ( array $post )
						{
							return parse_blocks( $post['content']['raw'] );
						},
					]
				);
			}
		}
	}
);
