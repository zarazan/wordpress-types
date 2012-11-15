<?php

$field_types = array(
	'excerpt_box' => array(
		'id' => 'address-meta-box',
	    'title' => 'Picture Excerpt',
	    'page' => 'gallery',
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
			array(
			   'name' => 'Description',
			   'desc' => 'Short description of the picture',
	           'id' => 'excerpt-text',
	           'type' => 'textarea'
			)
		)
	),
	'geo_box' => array(
		'id' => 'geo-meta-box',
	    'title' => 'Geographic Location',
	    'page' => 'dealer_location',
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
			array(
			   'name' => 'Latitude',
	           'id' => 'lat-text',
	           'type' => 'text'
			),
			array(
			   'name' => 'Longitude',
	           'id' => 'long-text',
	           'type' => 'text'
			)
		)
	),
	'address_box' => array(
		'id' => 'address-meta-box',
	    'title' => 'Dealership Address',
	    'page' => 'dealer_location',
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
			array(
			   'name' => 'Full Address',
	           'id' => 'lat-text',
	           'type' => 'text'
			)
		)
	)
);

function add_address_meta_box() {
	global $field_types;
	foreach ($field_types as $field_name => $box) {
		add_meta_box(
			$box['id'], 
			$box['title'], 
			'show_meta_box', 
			$box['page'], 
			$box['context'],
			$box['priority'],
			$box
		);
	}
}

add_action('add_meta_boxes', 'add_address_meta_box');
// Callback function to show fields in meta box
function show_meta_box($post, $params) {
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '<table class="form-table">';
	$meta_box = $params['args'];
    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
			case 'image':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="" size="30" style="width:97%" />', "";
        		break;
			}
        echo     '</td><td>',
            '</td></tr>';
    }
    echo '</table>';
}

add_action('save_post', 'custom_types_save_data');
// Save data from meta box
function custom_types_save_data($post_id) {
	global $field_types;
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
	foreach ($field_types as $field_name => $meta_box) {
    	foreach ($meta_box['fields'] as $field) {
	        $old = get_post_meta($post_id, $field['id'], true);
	        $new = $_POST[$field['id']];
	        if ($new && $new != $old) {
	            update_post_meta($post_id, $field['id'], $new);
	        } elseif ('' == $new && $old) {
	            delete_post_meta($post_id, $field['id'], $old);
	        }
	    }
	}
}
