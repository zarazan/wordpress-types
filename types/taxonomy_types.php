<?php
 
add_action( 'init', 'create_locations' );
function create_locations() {
 $labels = array(
    'name' => _x( 'Models', 'taxonomy general name' ),
    'singular_name' => _x( 'Model', 'taxonomy singular name' ),
    'all_items' => __( 'All Models' ),
    'edit_item' => __( 'Edit Model' ),
    'update_item' => __( 'Update Model' ),
    'add_new_item' => __( 'Add New Model' ),
    'new_item_name' => __( 'New Model Name' ),
  ); 	

  register_taxonomy('model','post',array(
    'labels' => $labels,
	'hierarchical' => true
  ));
}

add_action( 'init', 'create_products' );
function create_products() {
 $labels2 = array(
    'name' => _x( 'Products', 'taxonomy general name' ),
    'singular_name' => _x( 'Product', 'taxonomy singular name' ),
    'all_items' => __( 'All Products' ),
    'edit_item' => __( 'Edit Product' ),
    'update_item' => __( 'Update Product' ),
    'add_new_item' => __( 'Add New Product' ),
    'new_item_name' => __( 'New Product Name' ),
  ); 	

  register_taxonomy('product','post',array(
    'labels' => $labels2,
	'hierarchical' => true
  ));
}
