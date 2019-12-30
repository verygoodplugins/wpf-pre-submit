<?php

/*
Plugin Name: WP Fusion - Pre Submit
Description: Allows WP Fusion to watch inputs for changes and create / update contact records in the background.
Plugin URI: https://verygoodplugins.com/
Version: 1.0
Author: Very Good Plugins
Author URI: https://verygoodplugins.com/
*/


function enqueue_wpf_pre_submit_scripts() {

	wp_enqueue_script( 'wpf-pre-submit', plugin_dir_url( __FILE__ ) . 'assets/main.js', array( 'jquery' ) );
	wp_localize_script( 'wpf-pre-submit', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

}

add_action( 'wp_enqueue_scripts', 'enqueue_wpf_pre_submit_scripts' );

function wpf_create_update_contact() {

	// Check to see if it's an existing registered user

	$user = get_user_by( 'email', $_POST['user_email'] );

	$contact_id = false;

	if ( is_object( $user ) ) {

		$contact_id = wp_fusion()->user->get_contact_id( $user->ID, true );

	}

	if ( empty( $contact_id ) ) {

		// See if contact exists already
		$contact_id = wp_fusion()->crm->get_contact_id( $_POST['user_email'] );

		if ( ! empty( $contact_id ) ) {

			// Update existing contact
			wp_fusion()->crm->update_contact( $contact_id, $_POST );

		} else {

			// Add new contact
			$contact_id = wp_fusion()->crm->add_contact( $_POST );

		}
	}

	wp_send_json_success( $contact_id );

}


add_action( 'wp_ajax_nopriv_wpf_pre_submit', 'wpf_create_update_contact' );
