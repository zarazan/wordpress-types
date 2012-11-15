<?php

require_once locate_template('types/taxonomy_types.php');

$post_types = array(
	'dealer_location' => array(
		'labels' => array(
			'name' => 'Dealer Locations' ,
			'singular_name' => 'Dealer Location' ,
			'add_new_item' => 'New Dealer Location',
			'edit_item' => 'Edit Dealer Location'
		),
		'public' => true,
		'supports' => array('title', 'thumbnail'),
		'taxonomies' => array('product', 'model'),
		'menu_position' => 5
	),
	'gallery' => array(
		'labels' => array(
			'name' => 'Gallery Images',
			'singular_name' => 'Gallery Image',
			'add_new_item' => 'New Gallery Image',
			'edit_item' => 'Edit Dealer Location'
		),
		'public' => true,
		'supports' => array('title', 'thumbnail'),
		'taxonomies' => array('product', 'model'),
		'menu_position' => 5
	)
);

add_action('init', 'custom_post_types');

function custom_post_types() {
	global $post_types;
	foreach ($post_types as $post_name => $post_array) {
		register_post_type($post_name, $post_array);
	}
}

add_theme_support('post-thumbnails');

require_once locate_template('types/field_types.php');
